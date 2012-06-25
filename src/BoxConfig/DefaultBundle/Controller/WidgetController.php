<?php

namespace BoxConfig\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class WidgetController extends Controller
{
    public function topAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        switch ($slug) {
            case "hardware" :
                $title = "Hardware";
                $items = $em->getRepository('BoxConfigBoxBundle:Hardware')->getTop(5);
                $template = "BoxConfigDefaultBundle:Widget:top_hardware.html.twig";
                break;
            case "ide" :
                $title = "PHP IDE's";
                // @TODO: This needs to be created.
                $items = $em->getRepository('BoxConfigBoxBundle:Software')->getTop(4, 5);
                $template = "BoxConfigDefaultBundle:Widget:top_software.html.twig";
                break;
            case "os" :
                $title = "Operating Systems";
                $items = $em->getRepository('BoxConfigBoxBundle:Operatingsystem')->getTop(5);
                $template = "BoxConfigDefaultBundle:Widget:top_operatingsystem.html.twig";
                break;
            default :
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
                break;
        }


        // Sort on percentages
        uasort($items, function($a, $b) {
            return ($a->scalarPercentage < $b->scalarPercentage);
        });

        return $this->render($template, array("title" => $title, "items" => $items));
    }

    public function registerAction()
    {
        return $this->render('BoxConfigDefaultBundle:Widget:register.html.twig');
    }

    public function tipAction()
    {
        switch (rand(1,6)) {
            case 1:
                $tip = "Did you know you can easily add friends and view their configurations?";
                break;
            case 2:
                $tip = "Did you know that <b>PHPStorm</b> is the favourite PHP Editor?";
                break;
            case 3:
                $em = $this->getDoctrine()->getEntityManager();
                $items = $em->getRepository('BoxConfigBoxBundle:Operatingsystem')->getTop(1, true);
                $tip = "Did you know that <b>".(string)$items[0]->getOperatingsystem()."</b> is most virtualized operating system?";
                break;
            case 4:
                $em = $this->getDoctrine()->getEntityManager();
                $items = $em->getRepository('BoxConfigBoxBundle:Operatingsystem')->getTop(1);
                $tip = "Did you know that <b>".(string)$items[0]->getOperatingsystem()."</b> is most used operating system?";
                break;
            case 5:
                $em = $this->getDoctrine()->getEntityManager();
                $users = $em->getRepository('BoxConfigAccountBundle:User')->getCount();

                $em = $this->getDoctrine()->getEntityManager();
                $boxes = $em->getRepository('BoxConfigBoxBundle:Configuration')->getCount();

                $tip = "Our users have on average <b>".round($users / $boxes, 2)."</b> boxes registered.";
                break;

            default:
                $em = $this->getDoctrine()->getEntityManager();
                $users = $em->getRepository('BoxConfigAccountBundle:User')->getCount();

                $em = $this->getDoctrine()->getEntityManager();
                $boxes = $em->getRepository('BoxConfigBoxBundle:Configuration')->getCount();

                $tip = "Did you know that there are currently <b>".$users."</b> registered users with a total of <b>".$boxes."</b> boxes?";
                break;
        }
        return $this->render('BoxConfigDefaultBundle:Widget:tip.html.twig', array('tip' => $tip));
    }

    public function controlpanelAction()
    {
        return $this->render('BoxConfigDefaultBundle:Widget:controlpanel.html.twig');
    }

    public function matchconfigAction()
    {
        // @TODO: fetch current user. find matches, return these
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('BoxConfigAccountBundle:User')->findOneByUsername("johndoe");

        $matches = array();
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        return $this->render('BoxConfigDefaultBundle:Widget:matchconfig.html.twig', array('matches' => $matches));
    }

    public function matchmachineAction()
    {
        // @TODO: fetch current user. find matches, return these
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('BoxConfigAccountBundle:User')->findOneByUsername("johndoe");

        $matches = array();
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        $matches[] = array('user' => $user, 'percentage' => rand(100,10000) / 100);
        return $this->render('BoxConfigDefaultBundle:Widget:matchmachine.html.twig', array('matches' => $matches));
    }
}
