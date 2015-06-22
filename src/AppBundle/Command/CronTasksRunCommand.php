<?php

namespace AppBundle\Command;

// src/AppBundle/Command/CronTasksRunCommand.php

use UserBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CronTasksRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('MonitorUrl')
            ->setDescription('Ping Url and check the answer')
            ->addArgument('name', InputArgument::OPTIONAL, 'Qui voulez vous saluer??')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'Si définie, la tâche criera en majuscules')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getDoctrine()
            ->getRepository('UserBundle:Url');

        $dataUrl = $repository->findAll();

        foreach ($dataUrl as $urlelement) {

            $ch = curl_init($urlelement->getUrl());
            curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code == 200) {

                $em = $this->getDoctrine()->getManager();
                $urlObject = $em->getRepository('UserBundle:Url')->find($urlelement->getId());
                $urlObject ->setState('1');
                $em->flush();
            } else {

                $em = $this->getDoctrine()->getManager();
                $urlObject = $em->getRepository('UserBundle:Url')->find($urlelement->getId());
                $urlObject ->setState('0');
                $em->flush();
            }
        }
    }
}