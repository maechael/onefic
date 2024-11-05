<?php

use app\assets\SmartWizardAsset;
use app\models\Component;
use app\models\Equipment;
use app\models\EquipmentComponent;
use app\models\EquipmentSpec;
use buttflattery\formwizard\FormWizard;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

SmartWizardAsset::register($this);

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<?php $form = ActiveForm::begin([
    'id' => 'form-equipment-setup',
    // 'action' => 'create',
    'options' => [
        'enctype' => 'multipart/form-data',
        //'data-pjax' => true
    ],
    'method' => 'POST',
]); ?>

<div id="smartwizard">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#step-1">
                <div class="num">1</div>
                Equipment Details
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-2">
                <span class="num">2</span>
                Component/Parts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#step-3">
                <span class="num">3</span>
                Specification
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
            <?= $this->render('steps/_equipment-details', [
                'form' => $form,
                'equipment' => $equipment
            ]) ?>
        </div>
        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
            <?= $this->render('steps/_component-parts', [
                'form' => $form,
                'components' => [new EquipmentComponent]
            ]) ?>
        </div>
        <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
            <?= $this->render('steps/_specification', [
                'form' => $form,
                'equipmentSpecs' => [new EquipmentSpec]
            ]) ?>
        </div>
    </div>


    <!-- Include optional progressbar HTML -->

    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

</div>

<?php ActiveForm::end(); ?>


<?php
$this->registerJs(<<<JS
    let test = $('#smartwizard').smartWizard({
        selected: 0, // Initial selected step, 0 = first step
        theme: 'arrows', // theme for the wizard, related css need to include for other than default theme
        justified: true, // Nav menu justification. true/false
        autoAdjustHeight: true, // Automatically adjust content height
        backButtonSupport: true, // Enable the back button support
        enableUrlHash: false, // Enable selection of the step based on url hash
        transition: {
            animation: 'slideSwing', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
            speed: '400', // Animation speed. Not used if animation is 'css'
            easing: '', // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
            prefixCss: '', // Only used if animation is 'css'. Animation CSS prefix
            fwdShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on forward direction
            fwdHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on forward direction
            bckShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on backward direction
            bckHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on backward direction
        },
        toolbar: {
            position: 'bottom', // none|top|bottom|both
            showNextButton: true, // show/hide a Next button
            showPreviousButton: true, // show/hide a Previous button
            extraHtml: `<input id="equipment-form-submit" type="submit" class="btn btn-success" disabled="true"/>`
                        // <button class="btn btn-secondary" onclick="onCancel()">Cancel</button>`
        },
        anchor: {
            enableNavigation: true, // Enable/Disable anchor navigation 
            enableNavigationAlways: false, // Activates all anchors clickable always
            enableDoneState: true, // Add done state on visited steps
            markPreviousStepsAsDone: false, // When a step selected by url hash, all previous steps are marked done
            unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
            enableDoneStateNavigation: true // Enable/Disable the done state navigation
        },
        keyboard: {
            keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            keyLeft: [37], // Left key code
            keyRight: [39] // Right key code
        },
        lang: { // Language variables for button
            next: 'Next',
            previous: 'Previous'
        },
        disabledSteps: [], // Array Steps disabled
        errorSteps: [], // Array Steps error
        warningSteps: [], // Array Steps warning
        hiddenSteps: [], // Hidden steps
        getContent: null // Callback function for content loading
    });

    $("#smartwizard").on("initialized", function(e) {
        console.log("initialized");
    });

    $("#smartwizard").on("loaded", function(e) {
        // $('#equipment-form-submit');
        console.log("loaded");
    });

    $(".dynamicform_wrapper_component").on("afterInsert", function(e, item) {
        test.smartWizard("fixHeight");
    });

    $(".dynamicform_wrapper_component").on("afterDelete", function(e) {
        test.smartWizard("fixHeight");
    });

    $('body').on("click", ".add-part", (e) => {
        test.smartWizard("fixHeight");
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
        switch(stepPosition){
            case 'last':
                $('#equipment-form-submit').prop('disabled', false);
                break;
            default:
                $('#equipment-form-submit').prop('disabled', true);
                break;
        }
    });

    $(".dynamicform_wrapper_spec").on("afterInsert", function(e, item) {
        test.smartWizard("fixHeight");
    });

    $(".dynamicform_wrapper_spec").on("afterDelete", function(e, item) {
        test.smartWizard("fixHeight");
    });
    

    // ..this shit does not work
    // $('body').on("click", ".remove-part", (e) => {
    //     test.smartWizard("fixHeight");
    // });
JS);
