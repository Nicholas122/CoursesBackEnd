<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('homepage/index.html.twig');
    }

    /**
     * @Route("/init", name="init")
     */
    public function initAction(KernelInterface $kernel)
    {
        //$this->installCkeditor($kernel);
        //$this->installAssets($kernel);
        $this->clearCache($kernel);
        var_dump('Success!');
        die;
        return new Response();
    }

    private function installCkeditor(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array('command' => 'ckeditor:install'));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
    }

    private function installAssets(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array('command' => 'assets:install'));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
    }

    private function clearCache(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array('command' => 'cache:clear'));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
    }

}
