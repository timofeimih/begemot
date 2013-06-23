<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 18.06.13
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

class TidyBuilder
{

    public $textArray;
    protected $mixArray = array();

    private $text;
    private $config = array(
        'imageTag' => 'admin'
    );
    private $images;

    public function __construct($text, $config, $images)
    {

        $this->text = preg_replace('|<!-- template !-->.*?<!-- endtemplate !-->|sei', '', $text);
        $this->config = $config;
        $this->images = $images;
    }

    public function renderText()
    {


        $this->renderTemplates();
        if (count($this->mixArray)>0){
            $this->textToArray();
            $this->arrayToText();
        }

        return $this->text;

    }

    private function renderTemplates()
    {
        $config = $this->config;

        require_once(dirname(__FILE__) . '/templates/ThreeTemplate.php');

        while (count($this->images) > 0) {

            $template = new ThreeTemplate($config);

            if ($template->getImageCount() <= count($this->images)) {
                $template->cutImagesFromArray($this->images);
                $this->mixArray[] = $template->render();
            } else{
                break;
            }
        }


    }

    private function textToArray()
    {
        $this->textArray = explode('<p>', $this->text);

        $newTextArray = array();

        foreach ($this->textArray as $key => $textPart) {
            $pHtml = '<p>' . $textPart;

            $newTextArray[$key] = array();
            $newTextArray[$key]['text'] = $pHtml;
            $newTextArray[$key]['order'] = $key;

        }

        //придумать переменные
        $array1Count = count($newTextArray);
        $array2Count = count($this->mixArray);

        $mixFrequency = $array1Count / $array2Count;

        foreach ($this->mixArray as $key => $textPart) {
            $pHtml =  $textPart;

            $newMixArray[$key] = array();
            $newMixArray[$key]['text'] = $pHtml;
            $newMixArray[$key]['order'] = ($key) * $mixFrequency + 1 + rand(-1, 1);

        }

        $resultArray = array_merge($newTextArray, $newMixArray);

        usort($resultArray, 'tidyCmp');

        $this->textArray = $resultArray;

    }

    private function arrayToText()
    {
        $resultText = '';
        foreach ($this->textArray as $textPart) {
            $resultText .= $textPart['text'];
        }

        $this->text = $resultText;
    }


}

function tidyCmp($a, $b)
{
    if ($a['order'] == $b['order']) {
        return 0;
    }
    return ($a['order'] < $b['order']) ? -1 : 1;
}