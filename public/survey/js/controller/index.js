"use strict";

/* * JavaScript for the file index.html
 *  @author Sanket Rajgarhia
 *  @date   03/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* GLOBAL VARIABLES                                                        */
/*****************************************************************************/

// Global variable - associated with the - lock model select control
let lockModelSelectionGroup = document.getElementById("lock-model-group");

// Global variable - associated with the - lock model selection next button
let lockSelectionNextButton = document.getElementById("lock-selection-next");

// Global variable - associated with the - door specification next button
let doorSpecificationNextButton = document.getElementById(
    "door-specification-next");

/*****************************************************************************/
/* DOCUMENT - ON READY STATE CHANGE                                          */
/*****************************************************************************/

document.onreadystatechange = function(event) {

    // Attach the language specific scripts before the DOM is in ready state
    if (document.readyState !== 'complete') {

        let newLanguage = sessionStorage.getItem("LANGUAGE");
        if (newLanguage !== null) {
            language = newLanguage;
        }

        // Load language specific scripts
        switch (language) {
            case LANGUAGE.ENGLISH:
                loadScript("./../lib/lang/en/enum/page/index-enum.js");
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/lock/lock-enum.js")
                break;
            case LANGUAGE.THAI:
                loadScript("./../lib/lang/th/enum/page/index-enum.js");
                loadScript("./../lib/lang/th/enum/door/door-enum.js");
                loadScript("./../lib/lang/th/enum/lock/lock-enum.js")
                break;
            default:
                loadScript("./../lib/lang/en/enum/page/index-enum.js");
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/lock/lock-enum.js")
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
window.onload = function() {

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

    // Setup the index page
    let titleElement = document.getElementsByTagName("title")[0];
    titleElement.innerHTML = INDEX.TITLE;

    // Lock selection card setup
    let lockSelectionCardHeader = document.getElementById("lock-selection-card-header");
    lockSelectionCardHeader.innerHTML = LOCK_SELECTION_CARD.HEADER;
    let labelLockModel = document.getElementById("label-lock-model");
    labelLockModel.innerHTML = LOCK_SELECTION_CARD.LABEL_LOCK_MODEL;
    let suitabilityMessage = document.getElementById("suitability-message");
    suitabilityMessage.innerHTML = LOCK_SELECTION_CARD.SUITABILITY_MESSAGE;
    let doorType = document.getElementById("door-type");
    doorType.innerHTML = `<span class="field-name">` +
        LOCK_SELECTION_CARD.LABEL_DOOR_TYPE + `</span>` +
        `<span id="type-value"></span>`;
    let doorThicknessRange = document.getElementById("door-thickness");
    doorThicknessRange.innerHTML = `<span class="field-name">` +
        LOCK_SELECTION_CARD.LABEL_DOOR_THICKNESS + `</span>` +
        `<span id="thickness-value"></span>`;

    // Select buttons of the lock selection card
    let navLockSelectionNextButton = document.getElementById("lock-selection-next");
    navLockSelectionNextButton.setAttribute("value", NAVIGATION_BUTTONS.SELECT_BUTTON);

    // Door selection card setup
    let doorSelectionCardHeader = document.getElementById("door-specification-header");
    doorSelectionCardHeader.innerHTML = DOOR_SPECIFICATION_CARD.HEADER;
    let proceedMessage = document.getElementById("proceed-message");
    proceedMessage.innerHTML = DOOR_SPECIFICATION_CARD.PROCEED_MESSAGE;
    let labelNext = document.getElementById("label-next");
    labelNext.innerHTML = DOOR_SPECIFICATION_CARD.LABEL_NEXT;

    // Next buttons of the door selection card
    let navDoorSpecificationNextButton = document.getElementById("door-specification-next");
    navDoorSpecificationNextButton.setAttribute("value", NAVIGATION_BUTTONS.NEXT_BUTTON);

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

        // Add only if the lock is meant for swing doors
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

    //If storage data is found -  set the lock model select control to have
    // the value of the selected lock and display the door type and door
    // thickness suggestions.
    // Delete the session storage items and enable the selection button.
    // This scenario check if the user has pressed the back button of the
    // browser to reach this page.
    if (sessionStorage.getItem('lockModelSelected') !== null) {

        // Set the lock model select control to have the value of the
        // previously selected lock
        lockModelSelectionGroup.value = sessionStorage.getItem(
            'lockModelSelected');

        // Fetch the object specifying the door type and door thickness range
        let lock = lockCompatibility(
            lockModelSelectionGroup.value.toUpperCase());

        // Display the door type and door thickness suggestion <div>
        let suggestionDiv = document.getElementById("suggestion");
        let doorTypeValueElement = document.getElementById("type-value");
        let doorThicknessValueElement = document.getElementById("thickness-value");

        suggestionDiv.classList.remove("hide-suggestion");
        let text = document.createTextNode(lock.doorType);
        doorTypeValueElement.appendChild(text);
        text = document.createTextNode(lock.doorThickness);
        doorThicknessValueElement.appendChild(text);

        // Enable the lock model selection next button
        lockSelectionNextButton.disabled = false;

    } else {

        // Ensure that no lock models are selected by default
        lockModelSelectionGroup.options[0].selected = true

        // Ensure that the lock model selection next button is disabled by default
        lockSelectionNextButton.disabled = true;
    }

    // Delete the session storage items - at start of flow
    sessionStorage.removeItem('page');
    sessionStorage.removeItem('lockModelSelected');
    sessionStorage.removeItem('compatibleDoor');
    sessionStorage.removeItem('lockAndDoorData');
    sessionStorage.removeItem('customerData');
    sessionStorage.removeItem('salesPersonData');

};

/*****************************************************************************/
/* EVENT LISTENER - CALLBACKS                                                */
/*****************************************************************************/

/* The callback function fired on 'change' - for lock model select control. 
 * @param    
 * @return   
 * */
const lockSelectionOnChange = (event) => {

    // The suggestion <div> element
    let suggestionDiv = document.getElementById("suggestion");

    // The <span> elements withing the suggestion <div> to display value for 
    // the door type and door thickness range
    let doorTypeValueElement = document.getElementById("type-value");
    let doorThicknessValueElement = document.getElementById("thickness-value");

    // Reset the door type and door thickness values
    doorTypeValueElement.innerHTML = "";
    doorThicknessValueElement.innerHTML = "";

    // If a valid door model has been selected
    if (lockModelSelectionGroup.selectedIndex > 0) {

        // Enable the lock model selection next button
        lockSelectionNextButton.disabled = false;

        // Display the door type and door thickness suggestion <div>
        suggestionDiv.classList.remove("hide-suggestion");

        // Fetch the object specifying the door type and door thickness range
        let lock = lockCompatibility(
            lockModelSelectionGroup.value.toUpperCase());

        // Display the suggestion
        let text = document.createTextNode(lock.doorType);
        doorTypeValueElement.appendChild(text);
        text = document.createTextNode(lock.doorThickness);
        doorThicknessValueElement.appendChild(text);

    } // No valid door model is selected
    else {
        // Enable the lock model selection next button
        lockSelectionNextButton.disabled = true;

        // Hide the door type and door thickness suggestion <div>
        suggestionDiv.classList.add("hide-suggestion");
    }

}

/* The callback function fired on 'click' - for lock model next button control.
 * @param    
 * @return   
 * */
const loadSurveyPageOnClick = () => {

    // Save the page data, selected lock and associated door type and
    // door thickness range object to the session storage
    sessionStorage.setItem('page', "1");
    sessionStorage.setItem('lockModelSelected', lockModelSelectionGroup.value);
    sessionStorage.setItem('compatibleDoor',
        JSON.stringify(lockCompatibility(
            lockModelSelectionGroup.value.toUpperCase())));

}

/* The callback function fired on 'click' - for door specification 
 * next button control.
 * @param    
 * @return   
 * */
const loadSurveyPageOnSpecificationClick = () => {

    // Ensure that no lock models are selected by default
    lockModelSelectionGroup.options[0].selected = true

    // Save the page data to the session storage
    sessionStorage.setItem('page', "1");

}

/*****************************************************************************/
/* REGISTER EVENT LISTENERS                                                  */
/*****************************************************************************/

// Event listeners registered for the lock model select control
lockModelSelectionGroup.addEventListener("change", lockSelectionOnChange);

// Event listeners registered for the lock model selection next button
lockSelectionNextButton.addEventListener("click", loadSurveyPageOnClick);

// Event listeners registered for the door specification next button
doorSpecificationNextButton.addEventListener("click",
    loadSurveyPageOnSpecificationClick);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/