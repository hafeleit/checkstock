"use strict";

/* * JavaScript for the file lock-selection-survey.html - Global
 *  variables, constants and functions
 *  @author Sanket Rajgarhia
 *  @date   31/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* GLOBAL CONSTANTS                                                          */
/*****************************************************************************/

// A constant value to be used as a css class name for determining if an input 
// control received an invalid input which it is holding in its placeholder 
// property
const SWAP_VALUE = "swapValue";

/*****************************************************************************/
/* GLOBAL VARIABLE                                                          */
/*****************************************************************************/

// Define global variables in this section

/*****************************************************************************/
/* DOCUMENT - ON READY STATE CHANGE                                          */
/*****************************************************************************/

document.onreadystatechange = function (event) {

    // Attach the language specific scripts before the DOM is in ready state
    if (document.readyState !== 'complete') {

        let newLanguage = sessionStorage.getItem("LANGUAGE");
        if (newLanguage !== null) {
            language = newLanguage;
        }

        // Load language specific scripts
        switch (language) {
            case LANGUAGE.ENGLISH:
                loadScript("./../lib/lang/en/enum/page/lock-selection-survey-enum.js");
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/lock/lock-enum.js");
                loadScript("./../lib/lang/en/enum/message/message-enum.js");
                break;
            case LANGUAGE.THAI:
                loadScript("./../lib/lang/th/enum/page/lock-selection-survey-enum.js");
                loadScript("./../lib/lang/th/enum/door/door-enum.js");
                loadScript("./../lib/lang/th/enum/lock/lock-enum.js");
                loadScript("./../lib/lang/th/enum/message/message-enum.js");
                break;
            default:
                loadScript("./../lib/lang/en/enum/page/lock-selection-survey-enum.js");
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/lock/lock-enum.js");
                loadScript("./../lib/lang/en/enum/message/message-enum.js");
                break;
        }
    }

};

/*****************************************************************************/
/* WINDOWS ONLOAD                                                            */
/*****************************************************************************/

/* Anonymous function fired on window load. 
 * @param    
 * @return   
 * */
window.onload = function (event) {

    let page = sessionStorage.getItem("page");
    if (page !== null) {

        // Coming from home page or report page
        if (page === "1" || page === "2") {

            // Language links styling based on the selected language
            let englishLanguageAnchor = "";
            let thaiLanguageAnchor = "";

            switch (language) {
                case LANGUAGE.ENGLISH:

                    englishLanguageAnchor = document.getElementById("lang-en");
                    if (englishLanguageAnchor.classList.contains("selected-language") === false) {
                        englishLanguageAnchor.classList.add("selected-language")
                    }
                    thaiLanguageAnchor = document.getElementById("lang-th");
                    thaiLanguageAnchor.classList.remove("selected-language");
                    break;

                case LANGUAGE.THAI:

                    thaiLanguageAnchor = document.getElementById("lang-th");
                    if (thaiLanguageAnchor.classList.contains("selected-language") === false) {
                        thaiLanguageAnchor.classList.add("selected-language")
                    }
                    englishLanguageAnchor = document.getElementById("lang-en");
                    englishLanguageAnchor.classList.remove("selected-language");
                    break;

            }

            // Page setup
            let titleElement = document.getElementsByTagName("title")[0];
            titleElement.innerHTML = LOCK_SELECTION_SURVEY.TITLE;
            let pageHeading = document.getElementById("page-heading-h1");
            pageHeading.innerHTML = LOCK_SELECTION_SURVEY.PAGE_HEADING;

            // Initialize the lock selection card controls
            initializeLockCardControls();

            // Initialize the customer card controls
            initializeCustomerCardControls();

            // Initialize the sales person card controls
            initializeSalesPersonCardControls();

        }

        // Scroll to the top
        window.scrollTo(0, 0);

    } else {
        // Redirect to the index page
        window.location.replace("./../html/index.html");

    }

};

/*****************************************************************************/
/* EVENT LISTENER - CALLBACKS                                                */
/*****************************************************************************/

// Implement event listeners callbacks in this section

/*****************************************************************************/
/* HELPER FUNCTIONS                                                          */
/*****************************************************************************/

/* Helper function to provide the invalidate style for the input control. 
 * @param   {HTMLElement}   prependDiv   <div class="input-group-prepend">
 * @param   {HTMLElement}   inputGroupTextDiv  <span class="input-group-text">
 * @return   
 * */
const invalidateInputControl = (prependDiv, inputGroupTextDiv) => {

    // Add the class - prepend-invalid to the customer name prepend div
    prependDiv.classList.remove("prepend-valid");
    prependDiv.classList.add("prepend-invalid");

    // Make the input-group-text <div> transparent
    inputGroupTextDiv.classList.remove("input-group-text-opaque");
    inputGroupTextDiv.classList.add("input-group-text-transparent");

}

/* Helper function to provide the validate style for input the control. 
 * @param   {HTMLElement}   prependDiv   <div class="input-group-prepend">
 * @param   {HTMLElement}   inputGroupTextDiv  <span class="input-group-text">
 * @return   
 * */
const validateInputControl = (prependDiv, inputGroupTextDiv) => {

    // Add the class - prepend-valid to the customer name prepend div
    prependDiv.classList.remove("prepend-invalid");
    prependDiv.classList.add("prepend-valid");

    // Make the input-group-text <div> transparent
    inputGroupTextDiv.classList.remove("input-group-text-opaque");
    inputGroupTextDiv.classList.add("input-group-text-transparent");

}

/* Helper function to remove the validate and invalidate style for 
 * the input control.
 * @param   {HTMLElement}   prependDiv   <div class="input-group-prepend">
 * @param   {HTMLElement}   inputGroupTextDiv  <span class="input-group-text">
 * @return   
 * */
const resetValidation = (prependDiv, inputGroupTextDiv) => {

    // Remove the class - prepend-invalid to the customer name prepend div
    // if present
    prependDiv.classList.remove("prepend-invalid");
    // Remove the class - prepend-invalid to the customer name prepend div 
    // if present 
    prependDiv.classList.remove("prepend-valid");

    // Make the input-group-text <div> opaque
    inputGroupTextDiv.classList.remove("input-group-text-transparent");
    inputGroupTextDiv.classList.add("input-group-text-opaque");

}

/* Helper function to provide the invalidate style for the select control. 
 * @param   {HTMLElement}   selectionGroup   Top Field selection <div>
 * @param   {HTMLElement}   selectionDiv     <div class="input-group-prepend">
 * @return   
 * */
const invalidateSelectControl = (selectionGroup, selectionDiv) => {

    selectionGroup.setAttribute("style", "border-color: red");
    selectionDiv.getElementsByTagName("span")[0].classList.add("prepend-invalid-combo");
    selectionDiv.getElementsByTagName("i")[0].setAttribute("style", "color: #A52C36");

}

/* Helper function to provide the validate style for the select control. 
 * @param   {HTMLElement}   selectionGroup   Top Field selection <div>
 * @param   {HTMLElement}   selectionDiv     <div class="input-group-prepend">
 * @return   
 * */
const validateSelectControl = (selectionGroup, selectionDiv) => {

    selectionGroup.setAttribute("style", "border-color: green");
    selectionDiv.getElementsByTagName("span")[0].classList.remove("prepend-invalid-combo");
    selectionDiv.getElementsByTagName("span")[0].classList.add("prepend-valid-combo");
    selectionDiv.getElementsByTagName("i")[0].removeAttribute("style");

}

/* Helper function to remove the validate and invalidate style
 * for the select control.
 * @param   {HTMLElement}   selectionGroup   Top Field selection <div>
 * @param   {HTMLElement}   selectionDiv     <div class="input-group-prepend">
 * @return   
 * */
const resetSelectControl = (selectionGroup, selectionDiv) => {

    selectionGroup.removeAttribute("style");
    selectionDiv.getElementsByTagName("span")[0].classList.remove("prepend-valid-combo");
    selectionDiv.getElementsByTagName("span")[0].classList.remove("prepend-invalid-combo");
    selectionDiv.getElementsByTagName("i")[0].removeAttribute("style");

}

/* Helper function to show or hide the top level status message
 * for the select control.
 * @param   {boolean}  display   If true the the status message is displayed
 *                               else the status message is hidden
 * @param   {cssClassName} severity  low-severity/normal-severity/high-severity
 * @ param  {String} message The message to be displayed
 * @return   
 * */
const invalidStatusMessageDisplay = (display, severity = "low-severity", message = "") => {

    let statusId = document.getElementById("status");
    let messagePara = statusId.getElementsByTagName("p")[0];

    if (display === true) {

        messagePara.classList.remove("low-severity");
        messagePara.classList.remove("normal-severity");
        messagePara.classList.remove("high-severity");

        messagePara.classList.add(severity);
        messagePara.innerHTML = message;
        statusId.classList.remove("status-hidden");
        statusId.classList.add("status-displayed");

    } else {

        messagePara.classList.remove("low-severity");
        messagePara.classList.remove("normal-severity");
        messagePara.classList.remove("high-severity");

        messagePara.classList.add("normal-severity");
        messagePara.innerHTML = "";
        statusId.classList.add("status-hidden");
        statusId.classList.remove("status-displayed");

    }

}

/* Helper function to check if all input fields are validated.
 * @param  {HTMLElement} topLevelDivId for each card section
 * @return {boolean}    true if all fields are validated - false otherwise  
 * */
const allInputsAreValidated = (topLevelDivId) => {

    // Flag to check if all input fields were validated
    let allFieldsAreValidated = false;

    let topLevelDiv = document.getElementById(topLevelDivId);

    // Get all the div elements which have the class "input-group"
    let allInputContainerDivElements = topLevelDiv
        .getElementsByClassName("input-group");

    // Iterate over all the div elements 
    for (let containerDiv of allInputContainerDivElements) {

        // Get the div element with the class "input-group-prepend"
        // inside the container div
        let prependDiv = containerDiv
            .getElementsByClassName("input-group-prepend")[0];

        // If the container div contains the class "optional"
        // check if the input box has any value - if it does not have any
        // value - consider it to be validated
        if (containerDiv.classList.contains("optional") === true) {

            // Check if the container div has an input control
            if (containerDiv.getElementsByTagName("input").length > 0) {

                // If the length of the input value in the input control is 0
                // and the prepend div contains the class prepend-invalid
                if (containerDiv.getElementsByTagName("input")[0]
                    .value.length === 0 &&
                    prependDiv.classList.contains("prepend-invalid") === true) {
                    allFieldsAreValidated = false;
                    break;
                } else {
                    allFieldsAreValidated = true;
                    continue;
                }

            } // The container div has a textarea control
            else {

                // If the length of the textarea value in the textarea control is 0
                // and the prepend div contains the class prepend-invalid
                if (containerDiv.getElementsByTagName("textarea")[0]
                    .value.length === 0 &&
                    prependDiv.classList.contains("prepend-invalid") === true) {
                    allFieldsAreValidated = false;
                    break;
                } else {
                    allFieldsAreValidated = true;
                    continue;
                }

            }

        }

        if (prependDiv.classList.contains("prepend-valid")) {
            allFieldsAreValidated = true;
        } else {
            allFieldsAreValidated = false;
            break;
        }

    }

    return allFieldsAreValidated;

}

/* Helper function to initialize all the lock selection card fields.
 * @param  
 * @return 
 * */
const initializeLockCardControls = () => {

    // Setup the door lock card heading
    let lockAndDoorCardHeading = document.getElementById(
        "door-lock-card-heading");
    lockAndDoorCardHeading.innerHTML = LOCK_SELECTION_SURVEY.LOCK_CARD_HEADING;

    // Fields of the door lock selection card
    let lockModelComboDefault = document.getElementById("label-lock-model");
    lockModelComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_MODEL;
    let installationLocationComboDefault = document.getElementById(
        "label-installation-location");
    installationLocationComboDefault.innerHTML = LOCK_SELECTION_SURVEY
        .LOCK_INSTALLATION_LOCATION;
    let doorConditionComboDefault = document.getElementById("label-door-condition");
    doorConditionComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_DOOR_CONDITION;
    let existingDoorRetrofitComboDefault = document
        .getElementById("label-existing-door-retrofit");
    existingDoorRetrofitComboDefault.innerHTML = LOCK_SELECTION_SURVEY
        .LOCK_DOOR_RETROFIT;
    let doorTypeComboDefault = document.getElementById("label-door-type");
    doorTypeComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_DOOR_TYPE;
    let swingDoorTypeComboDefault = document.getElementById("label-swing-door-type");
    swingDoorTypeComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_SWING_DOOR_TYPE;
    let swingDoorJambComboDefault = document.getElementById("label-swing-door-jamb");
    swingDoorJambComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_SWING_DOOR_JAMB;
    let doorThicknessComboDefault = document.getElementById("label-door-thickness");
    doorThicknessComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_DOOR_THICKNESS;
    let doorThicknessInputPlaceholder = document.getElementById("input-door-thickness");
    doorThicknessInputPlaceholder.setAttribute("placeholder", LOCK_SELECTION_SURVEY.LOCK_DOOR_THICKNESS_INPUT);
    let doorMaterialComboDefault = document.getElementById("label-door-material");
    doorMaterialComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_DOOR_MATERIAL;
    let doorLeafComboDefault = document.getElementById("label-door-leaf");
    doorLeafComboDefault.innerHTML = LOCK_SELECTION_SURVEY.LOCK_DOOR_LEAF;

    // Previous and Next buttons of the door lock selection card
    let navPreviousButton = document.getElementById("lock-selection-previous");
    navPreviousButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_PREVIOUS_BUTTON);
    let navNextButton = document.getElementById("lock-selection-next");
    navNextButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_NEXT_BUTTON);

    // Add all the swing door - lock model name options to the lock model
    // group selection combo box
    let optionGroup = document.createElement("optgroup");
    optionGroup.setAttribute("label", DOOR_TYPE.SWING_DOOR);
    let optionGroupAdded = false;
    Object.keys(LOCK_MODEL).forEach(key => {

        let lockModelSelectionGroup = document.getElementById("lock-model-group");

        // The lock and door type compatibility object
        let compatibleDoor = lockCompatibility(
            key.toUpperCase());

        // Add only if the lock is meant for swing doors
        if (compatibleDoor.doorType.toUpperCase() ===
            DOOR_TYPE.SWING_DOOR.toUpperCase()) {

            if (optionGroupAdded === false) {
                lockModelSelectionGroup.appendChild(optionGroup);
                optionGroupAdded = true;
            }

            let optionTag = document.createElement("option");
            optionTag.setAttribute("value", LOCK_MODEL[key]);
            optionTag.setAttribute("data-door-type", DOOR_TYPE.SWING_DOOR);
            let textNode = document.createTextNode(LOCK_MODEL[key]);
            optionTag.appendChild(textNode);

            optionGroup.appendChild(optionTag);
        }

    });

    // Add all the sliding door - lock model name options to the lock model
    // group selection combo box
    optionGroup = document.createElement("optgroup");
    optionGroup.setAttribute("label", DOOR_TYPE.SLIDING_DOOR);
    optionGroupAdded = false;
    Object.keys(LOCK_MODEL).forEach(key => {

        let lockModelSelectionGroup = document.getElementById("lock-model-group");

        // The lock and door type compatibility object
        let compatibleDoor = lockCompatibility(
            key.toUpperCase());

        // Add only if the lock is meant for sliding doors
        if (compatibleDoor.doorType.toUpperCase() ===
            DOOR_TYPE.SLIDING_DOOR.toUpperCase()) {

            if (optionGroupAdded === false) {
                lockModelSelectionGroup.appendChild(optionGroup);
                optionGroupAdded = true;
            }

            let optionTag = document.createElement("option");
            optionTag.setAttribute("value", LOCK_MODEL[key]);
            optionTag.setAttribute("data-door-type", DOOR_TYPE.SLIDING_DOOR);
            let textNode = document.createTextNode(LOCK_MODEL[key]);
            optionTag.appendChild(textNode);

            optionGroup.appendChild(optionTag);
        }

    });

    // Add all the swing and sliding door - lock model name options to the
    // lock model group selection combo box
    optionGroup = document.createElement("optgroup");
    optionGroup.setAttribute("label", DOOR_TYPE.SWING_DOOR + " AND " +
        DOOR_TYPE.SLIDING_DOOR);
    optionGroupAdded = false;
    Object.keys(LOCK_MODEL).forEach(key => {

        let lockModelSelectionGroup = document.getElementById("lock-model-group");

        // The lock and door type compatibility object
        let compatibleDoor = lockCompatibility(
            key.toUpperCase());

        // Add only if the lock is meant for swing doors
        if (compatibleDoor.doorType.indexOf("/") > -1) {

            if (optionGroupAdded === false) {
                lockModelSelectionGroup.appendChild(optionGroup);
                optionGroupAdded = true;
            }

            let optionTag = document.createElement("option");
            optionTag.setAttribute("value", LOCK_MODEL[key]);
            optionTag.setAttribute("data-door-type", compatibleDoor.doorType);
            let textNode = document.createTextNode(LOCK_MODEL[key]);
            optionTag.appendChild(textNode);

            optionGroup.appendChild(optionTag);
        }

    });

    // Add all the installation locations options to the installation location
    // group selection combo box
    Object.keys(DOOR_INSTALLATION_LOCATION).forEach(key => {

        let installationLocationSelectionGroup = document.getElementById(
            "installation-location-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_INSTALLATION_LOCATION[key]);
        let textNode = document.createTextNode(DOOR_INSTALLATION_LOCATION[key]);
        optionTag.appendChild(textNode);
        installationLocationSelectionGroup.appendChild(optionTag);

    });

    // Add all the door condition options to the door condition
    // group selection combo box
    Object.keys(DOOR_CONDITION).forEach(key => {

        let doorConditionSelectionGroup = document.getElementById(
            "door-condition-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_CONDITION[key]);
        let textNode = document.createTextNode(DOOR_CONDITION[key]);
        optionTag.appendChild(textNode);
        doorConditionSelectionGroup.appendChild(optionTag);

    });

    // Add all the existing door retrofit options to the existing door retrofit
    // group selection combo box
    Object.keys(DOOR_RETROFIT).forEach(key => {

        let existingDoorRetrofitSelectionGroup = document.getElementById(
            "existing-door-retrofit-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_RETROFIT[key]);
        let textNode = document.createTextNode(DOOR_RETROFIT[key]);
        optionTag.appendChild(textNode);
        existingDoorRetrofitSelectionGroup.appendChild(optionTag);

    });

    // Add all the door type options to the door type
    // group selection combo box
    Object.keys(DOOR_TYPE).forEach(key => {

        let doorTypeSelectionGroup = document.getElementById(
            "door-type-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_TYPE[key]);
        let textNode = document.createTextNode(DOOR_TYPE[key]);
        optionTag.appendChild(textNode);
        doorTypeSelectionGroup.appendChild(optionTag);

    });

    // Add all the swing door type options to the swing door type
    // group selection combo box
    Object.keys(SWING_DOOR_TYPE).forEach(key => {

        let swingDoorTypeSelectionGroup = document.getElementById(
            "swing-door-type-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", SWING_DOOR_TYPE[key]);
        let textNode = document.createTextNode(SWING_DOOR_TYPE[key]);
        optionTag.appendChild(textNode);
        swingDoorTypeSelectionGroup.appendChild(optionTag);

    });

    // Add all the swing door jamb options to the swing door jamb
    // group selection combo box
    Object.keys(SWING_DOOR_JAMB).forEach(key => {

        let swingDoorJambSelectionGroup = document.getElementById(
            "swing-door-jamb-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", SWING_DOOR_JAMB[key]);
        let textNode = document.createTextNode(SWING_DOOR_JAMB[key]);
        optionTag.appendChild(textNode);
        swingDoorJambSelectionGroup.appendChild(optionTag);

    });

    // Add all the door thickness options to the door thickness
    // group selection combo box
    Object.keys(DOOR_THICKNESS_IN_MM).forEach(key => {

        let doorThicknessSelectionGroup = document.getElementById(
            "door-thickness-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_THICKNESS_IN_MM[key]);
        let textNode = document.createTextNode(DOOR_THICKNESS_IN_MM[key]);
        optionTag.appendChild(textNode);
        doorThicknessSelectionGroup.appendChild(optionTag);

    });

    // Add all the door material options to the door material
    // group selection combo box
    Object.keys(DOOR_MATERIAL).forEach(key => {

        let doorMaterialSelectionGroup = document.getElementById(
            "door-material-group");
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", DOOR_MATERIAL[key])
        let textNode = document.createTextNode(DOOR_MATERIAL[key]);
        optionTag.appendChild(textNode);
        doorMaterialSelectionGroup.appendChild(optionTag);

    });

    // Add all the swing door leaf options to the door leaf
    // group selection combo box
    optionGroup = document.createElement("optgroup");
    optionGroup.setAttribute("label",
        LOCK_SELECTION_SURVEY.LOCK_DOOR_LEAF_GROUP_LABEL_SWING_DOOR);
    optionGroupAdded = false;
    Object.keys(SWING_DOOR_LEAF).forEach(key => {

        let doorLeafSelectionGroup = document.getElementById(
            "door-leaf-group");

        if (optionGroupAdded === false) {
            doorLeafSelectionGroup.appendChild(optionGroup);
            optionGroupAdded = true;
        }
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", SWING_DOOR_LEAF[key]);
        optionTag.setAttribute("data-door-type", DOOR_TYPE.SWING_DOOR);
        let textNode = document.createTextNode(SWING_DOOR_LEAF[key]);
        optionTag.appendChild(textNode);

        optionGroup.appendChild(optionTag);

    });

    // Add all the sliding door leaf options to the door leaf
    // group selection combo box
    optionGroup = document.createElement("optgroup");
    optionGroup.setAttribute("label",
        LOCK_SELECTION_SURVEY.LOCK_DOOR_LEAF_GROUP_LABEL_SLIDING_DOOR);
    optionGroupAdded = false;
    Object.keys(SLIDING_DOOR_LEAF).forEach(key => {

        let doorLeafSelectionGroup = document.getElementById(
            "door-leaf-group");
        if (optionGroupAdded === false) {
            doorLeafSelectionGroup.appendChild(optionGroup);
            optionGroupAdded = true;
        }
        let optionTag = document.createElement("option");
        optionTag.setAttribute("value", SLIDING_DOOR_LEAF[key]);
        optionTag.setAttribute("data-door-type", DOOR_TYPE.SLIDING_DOOR);
        let textNode = document.createTextNode(SLIDING_DOOR_LEAF[key]);
        optionTag.appendChild(textNode);

        optionGroup.appendChild(optionTag);

    });

    // If the user is returning to the page after filling all the form details
    // recreate the filled up lock and door data card
    let lockAndDoorData = sessionStorage.getItem("lockAndDoorData");
    if (lockAndDoorData !== null) {

        lockAndDoorData = JSON.parse(lockAndDoorData);

        lockModelSelectionGroup.value = lockAndDoorData.lockModel;
        lockModelSelectionGroup.dispatchEvent(new Event("change"));
        installationLocationSelectionGroup.value = lockAndDoorData.installationLocation;
        installationLocationSelectionGroup.dispatchEvent(new Event("change"));
        doorConditionSelectionGroup.value = lockAndDoorData.doorCondition;
        doorConditionSelectionGroup.dispatchEvent(new Event("change"));
        existingDoorRetrofitSelectionGroup.value = lockAndDoorData.existingDoorRetrofit;
        existingDoorRetrofitSelectionGroup.dispatchEvent(new Event("change"));
        doorTypeSelectionGroup.value = lockAndDoorData.doorType;
        doorTypeSelectionGroup.dispatchEvent(new Event("change"));
        swingDoorTypeSelectionGroup.value = lockAndDoorData.swingDoorType;
        swingDoorTypeSelectionGroup.dispatchEvent(new Event("change"));
        swingDoorJambSelectionGroup.value = lockAndDoorData.swingDoorJamb;
        swingDoorJambSelectionGroup.dispatchEvent(new Event("change"));
        doorThicknessSelectionGroup.value = lockAndDoorData.doorThickness;
        doorThicknessSelectionGroup.dispatchEvent(new Event("change"));

        if (doorThicknessSelectionGroup.value.toUpperCase() ===
            DOOR_THICKNESS_IN_MM.MM_OTHER.toUpperCase()) {
            doorThicknessInputGroup.value = lockAndDoorData.doorThicknessInput;
        }

        doorMaterialSelectionGroup.value = lockAndDoorData.doorMaterial;
        doorMaterialSelectionGroup.dispatchEvent(new Event("change"));
        doorLeafSelectionGroup.value = lockAndDoorData.doorLeaf;
        doorLeafSelectionGroup.dispatchEvent(new Event("change"));

    } // Check if the user has selected a lock in the index.html file 
    else {

        // If the user has selected a lock in the index.html file 
        let lockModel = sessionStorage.getItem("lockModelSelected");
        if (lockModel !== null) {

            let compatibleDoor = JSON.parse(sessionStorage.getItem("compatibleDoor"));

            // Select the lock model - automatically
            let lockModelSelectionGroup = document.getElementById("lock-model-group");
            lockModelSelectionGroup.value = lockModel;

            // Dispatch the "change" Event on model lock selection
            lockModelSelectionGroup.dispatchEvent(new Event("change"));

            // For displayig the icons
            installationLocationSelectionGroup.dispatchEvent(new Event("change"));
            existingDoorRetrofitSelectionGroup.dispatchEvent(new Event("change"));

            // Select the door type - automatically
            let doorTypeSelectionGroup = document.getElementById("door-type-group");

            // Check if the door is compatible with - both - Swing and Sliding type
            // If it is then set the door type selection to Swing
            if (compatibleDoor.doorType.indexOf('/') > -1) {
                doorTypeSelectionGroup.value = DOOR_TYPE.SWING_DOOR;
            } else {
                doorTypeSelectionGroup.value = compatibleDoor.doorType;
            }

            // DO NOT DELETE THE FOLLOWING COMMENTS
            //ENABLE THE FOLLOWING COMMENT ONLY IF REQUIRED
            // doorTypeSelectionGroup.dispatchEvent(new Event("change"));

            // Select the door thickness - automatically
            let doorThicknessSelectionGroup = document.getElementById("door-thickness-group");
            doorThicknessSelectionGroup.value = compatibleDoor.doorThickness;

            // DO NOT DELETE THE FOLLOWING COMMENTS
            //ENABLE THE FOLLOWING COMMENT ONLY IF REQUIRED
            // doorThicknessSelectionGroup.dispatchEvent(new Event("change"));

        }
    }

}

/* Helper function to initialize all the customer card fields.
 * @param  
 * @return 
 * */
const initializeCustomerCardControls = () => {

    // Setup the customer card heading
    let customerCardHeading = document.getElementById(
        "customer-card-heading");
    customerCardHeading.innerHTML = LOCK_SELECTION_SURVEY.CUSTOMER_CARD_HEADING;

    // Fields of the customer card
    let customerNameInput = document.getElementById("input-customer-name");
    customerNameInput.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .CUSTOMER_NAME_PLACEHOLDER);
    let invalidFeedBackDiv = customerNameInput.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_NAME_INVALID_MESSAGE_FEEDBACK;
    let customerMobileInput = document.getElementById("input-customer-mobile");
    customerMobileInput.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .CUSTOMER_MOBILE_PLACEHOLDER);
    invalidFeedBackDiv = customerMobileInput.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_MOBILE_INVALID_MESSAGE_FEEDBACK;
    let customerAddress1Input = document.getElementById("input-customer-address1");
    customerAddress1Input.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS1_PLACEHOLDER);
    invalidFeedBackDiv = customerAddress1Input.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS1_INVALID_MESSAGE_FEEDBACK;
    let customerAddress2Input = document.getElementById("input-customer-address2");
    customerAddress2Input.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS2_PLACEHOLDER);
    invalidFeedBackDiv = customerAddress2Input.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS2_INVALID_MESSAGE_FEEDBACK;
    let customerAddress3Input = document.getElementById("input-customer-address3");
    customerAddress3Input.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS3_PLACEHOLDER);
    invalidFeedBackDiv = customerAddress3Input.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDRESS3_INVALID_MESSAGE_FEEDBACK;
    let customerAdditionalInformationTextArea = document
        .getElementById("input-customer-info");
    customerAdditionalInformationTextArea
        .setAttribute("placeholder", LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDITIONAL_INFORMATION_PLACEHOLDER);
    invalidFeedBackDiv = customerAdditionalInformationTextArea.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .CUSTOMER_ADDITIONAL_INFORMATION_INVALID_MESSAGE_FEEDBACK;

    // Previous and Next buttons of the customer card
    let navPreviousButton = document.getElementById("customer-previous");
    navPreviousButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_PREVIOUS_BUTTON);
    let navNextButton = document.getElementById("customer-next");
    navNextButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_NEXT_BUTTON);

    // Check if the customer data has been captured - if found then 
    // initialize the customer fields with the previously captured data
    let customerData = sessionStorage.getItem("customerData");
    if (customerData !== null) {

        customerData = JSON.parse(customerData);
        customerNameInput.value = customerData.customerName;
        customerMobileInput.value = customerData.customerMobile;
        customerAddress1Input.value = customerData.customerAddress1;
        customerAddress2Input.value = customerData.customerAddress2;
        customerAddress3Input.value = customerData.customerAddress3;
        customerInformationTextArea.value = customerData.customerInformation;

        // Apply the valid and invalid styles
        customerNameInput.dispatchEvent(new Event("blur"));
        customerMobileInput.dispatchEvent(new Event("blur"));
        customerAddress1Input.dispatchEvent(new Event("blur"));
        customerAddress2Input.dispatchEvent(new Event("blur"));
        customerAddress3Input.dispatchEvent(new Event("blur"));
        customerInformationTextArea.dispatchEvent(new Event("blur"));

        if (allInputsAreValidated("customer-information-capture") === false) {

            // Display the top level warning message
            invalidStatusMessageDisplay(true, "high-severity",
                MESSAGE.MESSAGE_MISSING_INPUT);

        } else {

            // Hide the status message
            invalidStatusMessageDisplay(false);

        }


    }

}

/* Helper function to initialize all the sales person card fields.
 * @param  
 * @return 
 * */
const initializeSalesPersonCardControls = () => {

    // Setup the sales person card heading
    let salesPersonCardHeading = document.getElementById(
        "sales-person-card-heading");
    salesPersonCardHeading.innerHTML = LOCK_SELECTION_SURVEY.SALES_PERSON_CARD_HEADING;

    // Fields of the sales person card
    let salesPersonIdInput = document.getElementById("input-sales-person-id");
    salesPersonIdInput.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .SALES_PERSON_ID_PLACEHOLDER);
    let invalidFeedBackDiv = salesPersonIdInput.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .SALES_PERSON_ID_INVALID_MESSAGE_FEEDBACK;
    let salesPersonNameInput = document.getElementById("input-sales-person-name");
    salesPersonNameInput.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .SALES_PERSON_NAME_PLACEHOLDER);
    invalidFeedBackDiv = salesPersonNameInput.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .SALES_PERSON_NAME_INVALID_MESSAGE_FEEDBACK;
    let salesPersonLocationTextArea = document.getElementById("input-sales-person-info");
    salesPersonLocationTextArea.setAttribute("placeholder", LOCK_SELECTION_SURVEY
        .SALES_PERSON_LOCATION_PLACEHOLDER);
    invalidFeedBackDiv = salesPersonLocationTextArea.nextElementSibling;
    invalidFeedBackDiv.innerHTML = LOCK_SELECTION_SURVEY
        .SALES_PERSON_LOCATION_INVALID_MESSAGE_FEEDBACK;

    // Previous and Next buttons of the sales person card
    let navPreviousButton = document.getElementById("sales-person-previous");
    navPreviousButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_PREVIOUS_BUTTON);
    let navNextButton = document.getElementById("sales-person-next");
    navNextButton.setAttribute("value", NAVIGATION_BUTTONS.LOCK_NEXT_BUTTON);

    // Check if the sales person data has been captured - if found then 
    // initialize the sales person fields with the previously captured data
    let salesPersonData = sessionStorage.getItem("salesPersonData");
    if (salesPersonData !== null) {

        salesPersonData = JSON.parse(salesPersonData);

        salesPersonIdInput.value = salesPersonData.salesPersonID;
        salesPersonNameInput.value = salesPersonData.salesPersonName;
        salesPersonLocationTextArea.value = salesPersonData.salesPersonLocation;

        // Apply the valid and invalid styles
        salesPersonIdInput.dispatchEvent(new Event("blur"));
        salesPersonNameInput.dispatchEvent(new Event("blur"));
        salesPersonLocationTextArea.dispatchEvent(new Event("blur"));

        if (allInputsAreValidated("sale-person-information-capture") === false) {

            // Display the top level warning message
            invalidStatusMessageDisplay(true, "high-severity",
                MESSAGE.MESSAGE_MISSING_INPUT);

        } else {

            // Hide the status message
            invalidStatusMessageDisplay(false);

        }


    }

}

/*****************************************************************************/
/* REGISTER EVENT LISTENERS                                                  */
/*****************************************************************************/

// Register event listeners in this section

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/