<?php

/**
 * Este programa envia e recebe dados de um Arduino a partir de uma comunicação
 * serial realizada entre o computador e o microcontrolador.
 *
 * @author Vinícius Silva <viniciuspsw@gmail.com>
 * @copyright (c) 2018
 */

require_once 'vendor/autoload.php';

class App
{
    /**
     * The Mustache template engine instance.
     *
     * @var \Mustache_Engine
     */
    private $mustache;

    /**
     * The PhpSerial instance.
     *
     * @var \PhpSerial
     */
    private $serial;

    /**
     * The options to render with the temaplate.
     *
     * @var array
     */
    private $options;

    /**
     * Application constructor
     *
     * @return void
     */
    public function __construct ()
    {
        $this->mustache = new Mustache_Engine(['loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/views')]);
        $this->serial = new PhpSerial;
        $this->options = [];
    }

    /**
     * Run application
     *
     * @return void
     */
    public function run ()
    {
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $this->sendSerial($_GET['status']);
        }

        if (!isset($_GET['no-render'])) {
            echo $this->mustache->render('index', $this->options);
        }
    }

    /**
     * Send info to Arduino via serial communication
     *
     * @param string $action
     *
     * @return void
     */
    public function sendSerial ($action)
    {
        $this->serial->deviceSet('COM7');
        $this->serial->deviceOpen();

        $message = ($action == 'on') ? 'l' : 'd';

        $this->serial->sendMessage($message);
    }
}

$app = new App;
$app->run();
