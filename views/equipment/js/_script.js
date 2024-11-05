let wizard = $('#smartwizard').smartWizard({
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
    extraHtml: `<input id="supplier-form-submit" type="submit" class="btn btn-success" disabled="true"/>`,
    // <button class="btn btn-secondary" onclick="onCancel()">Cancel</button>`
  },
  anchor: {
    enableNavigation: true, // Enable/Disable anchor navigation
    enableNavigationAlways: false, // Activates all anchors clickable always
    enableDoneState: true, // Add done state on visited steps
    markPreviousStepsAsDone: false, // When a step selected by url hash, all previous steps are marked done
    unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
    enableDoneStateNavigation: true, // Enable/Disable the done state navigation
  },
  keyboard: {
    keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
    keyLeft: [37], // Left key code
    keyRight: [39], // Right key code
  },
  lang: {
    // Language variables for button
    next: 'Next',
    previous: 'Previous',
  },
  disabledSteps: [], // Array Steps disabled
  errorSteps: [], // Array Steps error
  warningSteps: [], // Array Steps warning
  hiddenSteps: [], // Hidden steps
  getContent: null, // Callback function for content loading
});

$('#smartwizard').on(
  'showStep',
  function (e, anchorObject, stepIndex, stepDirection, stepPosition) {
    switch (stepPosition) {
      case 'last':
        $('#supplier-form-submit').prop('disabled', false);
        break;
      default:
        $('#supplier-form-submit').prop('disabled', true);
        break;
    }
  }
);

let dualListbox = $('.duallistbox').bootstrapDualListbox({
  selectorMinimalHeight: 400,
});

$('#sd-business-files').on('fileclear', (e) => {
  wizard.smartWizard('fixHeight');
});

$('#sd-business-files').on('filebatchselected', (e) => {
  wizard.smartWizard('fixHeight');
});

$('#sd-business-files').on('filecleared', function (event) {
  wizard.smartWizard('fixHeight');
});

$('body').on('fileclear', '.b-business-files', (e) => {
  wizard.smartWizard('fixHeight');
});

$('body').on('filebatchselected', '.b-business-files', (e) => {
  wizard.smartWizard('fixHeight');
});

$('body').on('filecleared', '.b-business-files', function (event) {
  wizard.smartWizard('fixHeight');
});

$('.dynamicform_wrapper_branch').on('afterInsert', function (e, item) {
  wizard.smartWizard('fixHeight');
});

$('.dynamicform_wrapper_branch').on('afterDelete', function (e) {
  wizard.smartWizard('fixHeight');
});

$('body').on('change', '.depdrop-custom', function () {
  var depends = $(this).data('depends');
  var depdropId = $(this).data('depdrop-id');
  var itemClass = $(this).data('item-class');
  var allDependents = $('*[data-depends~="' + depdropId + '"]');
  var dependants = $(this)
    .closest('.' + itemClass)
    .find(allDependents);

  $.each(dependants, function (index) {
    var dependant = $(this);
    var dependsOn = dependant.data('depends');
    dependsOn = dependsOn.split(' ');
    var hasChosen = true;
    var data = new Object();
    data.depdrop_parents = [];

    $.each(dependsOn, function (i, l) {
      var dependOnVal = dependant
        .closest('.' + itemClass)
        .find($('*[data-depdrop-id="' + l + '"]'))
        .val();

      if (!dependOnVal) {
        hasChosen = false;
      } else {
        data.depdrop_parents[i] = dependOnVal;
      }
    });

    if (hasChosen) {
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: String(dependant.data('url')),
        data: data,
      }).done(function (items) {
        dependant.find('option').not(':first').remove();

        $.each(items.output, function (itemIndex, item) {
          var newOption = new Option(item.name, item.id, false, false);
          dependant.append(newOption);
        });

        dependant.prop('disabled', false);
      });

      //   dependant.trigger('change');
    } else {
      dependant.prop('disabled', true);
    }
  });
});
