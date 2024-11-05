<?php

namespace app\controllers;

use app\assets\ChartAsset;
use kartik\mpdf\Pdf;
use app\models\reports\FicProduct;
use Yii;
use yii\helpers\ArrayHelper;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // return $this->render('index');
        $models = [];
        $models[] = new FicProduct(['prodcount' => [168, 101, 23, 141, 94, 5, 136, 142, 106, 77, 176, 35], 'region' => "Region I", 'color' => "yellow"]);
        $models[] = new FicProduct(['prodcount' => [114, 75, 177, 170, 80, 29, 32, 71, 124, 146, 102], 'region' => "NCR", 'color' => "red"]);
        return $this->render('index', ['models' => $models]);
    }

    public function actionTest()
    {
        return $this->render('test');
    }
    public function actionFicProductReport()
    {
        $models = [];
        $models[] = new FicProduct(['prodcount' => [168, 101, 23, 141, 94, 5, 136, 142, 106, 77, 176, 35], 'region' => "Region I", 'color' => "yellow"]);
        $models[] = new FicProduct(['prodcount' => [114, 75, 177, 170, 80, 29, 32, 71, 124, 146, 102], 'region' => "NCR", 'color' => "red"]);
        return $this->render('fic-product-report', ['models' => $models]);
    }
    public function actionTestPdf()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('_pdf'),
            'options' => [
                // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'Privacy Policy - Krajee.com',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'Kartik Visweswaran',
                'SetCreator' => 'Kartik Visweswaran',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        return $pdf->render();
    }
}
