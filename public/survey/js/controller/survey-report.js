"use strict";

/* * JavaScript for the file survey-report.html
 *  @author Sanket Rajgarhia
 *  @date   09/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* GLOBAL VARIABLES                                                          */
/*****************************************************************************/

// Type of report formatting to apply to a <div>
const NONE = "";
const WARNING = "WARNING";
const CAUTION = "CAUTION";

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
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/page/survey-report-enum.js");
                break;
            case LANGUAGE.THAI:
                loadScript("./../lib/lang/th/enum/door/door-enum.js");
                loadScript("./../lib/lang/th/enum/page/survey-report-enum.js");
                break;
            default:
                loadScript("./../lib/lang/en/enum/door/door-enum.js");
                loadScript("./../lib/lang/en/enum/page/survey-report-enum.js");
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
window.onload = function(event) {


    // Coming from lock survey selection page
    let page = sessionStorage.getItem("page");
    if (page === "2") {

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

        // Setup the survey report page
        let titleElement = document.getElementsByTagName("title")[0];
        titleElement.innerHTML = SURVEY_REPORT.TITLE;
        let pageHeading = document.getElementById("page-heading-h1");
        pageHeading.innerHTML = SURVEY_REPORT.PAGE_HEADING;
        let reportTitle = document.getElementById("report-title");
        reportTitle.innerHTML = SURVEY_REPORT.REPORT_TITLE;
        let reportPrint = document.getElementById("report-print");
        reportPrint.innerHTML = SURVEY_REPORT.PRINT_BUTTON;
        let reportDownload = document.getElementById("report-download");
        reportDownload.innerHTML = SURVEY_REPORT.DOWNLOAD_BUTTON;

        let customerData = sessionStorage.getItem("customerData");
        if (customerData !== null) {

            customerData = JSON.parse(customerData);

            formatReportFields("customerName",
                REPORT_FIELD.CUSTOMER_NAME.toUpperCase(),
                customerData.customerName.toUpperCase());
            formatReportFields("customerMobile",
                REPORT_FIELD.CUSTOMER_MOBILE.toUpperCase(),
                customerData.customerMobile.toUpperCase());
            formatReportFields("customerAddress",
                REPORT_FIELD.CUSTOMER_ADDRESS.toUpperCase(),
                customerData.customerAddress1.toUpperCase() + "\n" +
                customerData.customerAddress2.toUpperCase() + "\n" +
                customerData.customerAddress3.toUpperCase());
            let customerInformation = customerData.customerInformation.toUpperCase();
            let customerInformationLines = customerInformation.match(/(.|[\r\n]){1,50}/g);
            customerInformation = "";
            if (customerInformationLines !== null) {
                for (let line of customerInformationLines) {
                    customerInformation += line + "\n ";
                }
            }


            formatReportFields("customerInformation",
                REPORT_FIELD.CUSTOMER_INFORMATION.toUpperCase(), customerInformation);

        }

        let salesPersonData = sessionStorage.getItem("salesPersonData");
        if (salesPersonData !== null) {

            salesPersonData = JSON.parse(salesPersonData);

            formatReportFields("salesPersonID",
                REPORT_FIELD.SALES_PERSON_ID.toUpperCase(),
                salesPersonData.salesPersonID.toUpperCase());
            formatReportFields("salesPersonName",
                REPORT_FIELD.SALES_PERSON_NAME.toUpperCase(),
                salesPersonData.salesPersonName.toUpperCase());

            let salesPersonLocation = salesPersonData.salesPersonLocation.toUpperCase();
            let salesPersonLocationLines = salesPersonLocation.match(/(.|[\r\n]){1,50}/g);
            salesPersonLocation = "";
            if (salesPersonLocationLines !== null) {
                for (let line of salesPersonLocationLines) {
                    salesPersonLocation += line + "\n ";
                }
            }
            formatReportFields("salesPersonLocation",
                REPORT_FIELD.SALES_PERSON_LOCATION.toUpperCase(),
                salesPersonLocation.toUpperCase());
        }

        let lockAndDoorData = sessionStorage.getItem("lockAndDoorData");
        if (lockAndDoorData !== null) {

            lockAndDoorData = JSON.parse(lockAndDoorData);

            let surveyDetails = document.getElementById("survey-details");
            let surveyDetailsValue = document.createElement("h3");
            surveyDetailsValue.innerHTML = REPORT_FIELD.SURVEY_DETAILS.toUpperCase();
            surveyDetails.appendChild(surveyDetailsValue);

            formatReportFields("lockModel",
                REPORT_FIELD.LOCK_MODEL.toUpperCase(), lockAndDoorData.lockModel);

            formatReportFields("installationLocation",
                REPORT_FIELD.LOCK_INSTALLATION_LOCATION.toUpperCase(),
                lockAndDoorData.installationLocation);
            if (lockAndDoorData.installationLocationMessage.trim().length > 0) {
                formatReportFields("installationLocationMessage",
                    REPORT_FIELD.LOCK_INSTALLATION_LOCATION_MESSAGE.toUpperCase(),
                    lockAndDoorData.installationLocationMessage, WARNING);
            }

            formatReportFields("doorCondition",
                REPORT_FIELD.LOCK_DOOR_CONDITION.toUpperCase(),
                lockAndDoorData.doorCondition);
            if (lockAndDoorData.doorConditionMessage.trim().length > 0) {
                formatReportFields("doorConditionMessage",
                    REPORT_FIELD.LOCK_DOOR_CONDITION_MESSAGE.toUpperCase(),
                    lockAndDoorData.doorConditionMessage, WARNING);
            }
            if (lockAndDoorData.doorCondition.toUpperCase() ===
                DOOR_CONDITION.INSTALLED.toUpperCase()) {

                formatReportFields("existingDoorRetrofit",
                    REPORT_FIELD.LOCK_DOOR_RETROFIT.toUpperCase(),
                    lockAndDoorData.existingDoorRetrofit);
                if (lockAndDoorData.existingDoorRetrofitMessage.trim().length > 0) {
                    formatReportFields("existingDoorRetrofitMessage",
                        REPORT_FIELD.LOCK_DOOR_RETROFIT_MESSAGE.toUpperCase(),
                        lockAndDoorData.existingDoorRetrofitMessage, WARNING);
                }
                if (lockAndDoorData.existingDoorRetrofitCaution.trim().length > 0) {
                    formatReportFields("existingDoorRetrofitCaution",
                        REPORT_FIELD.LOCK_DOOR_RETROFIT_CAUTION.toUpperCase(),
                        lockAndDoorData.existingDoorRetrofitCaution, CAUTION);
                }
            }

            formatReportFields("doorType",
                REPORT_FIELD.LOCK_DOOR_TYPE.toUpperCase(),
                lockAndDoorData.doorType);
            if (lockAndDoorData.doorTypeMessage.trim().length > 0) {
                formatReportFields("doorTypeMessage",
                    REPORT_FIELD.LOCK_DOOR_TYPE_MESSAGE.toUpperCase(),
                    lockAndDoorData.doorTypeMessage, WARNING);
            }

            if (lockAndDoorData.doorType.toUpperCase() ===
                DOOR_TYPE.SWING_DOOR.toUpperCase()) {

                formatReportFields("swingDoorType",
                    REPORT_FIELD.LOCK_SWING_DOOR_TYPE.toUpperCase(),
                    lockAndDoorData.swingDoorType);
                if (lockAndDoorData.swingDoorTypeMessage.trim().length > 0) {
                    formatReportFields("swingDoorTypeMessage",
                        REPORT_FIELD.LOCK_SWING_DOOR_TYPE_MESSAGE.toUpperCase(),
                        lockAndDoorData.swingDoorTypeMessage, WARNING);
                }
                formatReportFields("swingDoorJamb",
                    REPORT_FIELD.LOCK_SWING_DOOR_JAMB.toUpperCase(),
                    lockAndDoorData.swingDoorJamb);
                if (lockAndDoorData.swingDoorJambMessage.trim().length > 0) {
                    formatReportFields("swingDoorJambMessage",
                        REPORT_FIELD.LOCK_SWING_DOOR_JAMB_MESSAGE.toUpperCase(),
                        lockAndDoorData.swingDoorJambMessage, WARNING);
                }
                if (lockAndDoorData.swingDoorJambCaution.trim().length > 0) {
                    formatReportFields("swingDoorJambCaution",
                        REPORT_FIELD.LOCK_SWING_DOOR_JAMB_CAUTION.toUpperCase(),
                        lockAndDoorData.swingDoorJambCaution, CAUTION);
                }
            }

            if (lockAndDoorData.doorThicknessInput.trim().length === 0) {
                formatReportFields("doorThickness",
                    REPORT_FIELD.LOCK_DOOR_THICKNESS.toUpperCase(),
                    lockAndDoorData.doorThickness);
                if (lockAndDoorData.doorThicknessMessage.trim().length > 0) {
                    formatReportFields("doorThicknessMessage",
                        REPORT_FIELD.LOCK_DOOR_THICKNESS_MESSAGE.toUpperCase(),
                        lockAndDoorData.doorThicknessMessage, WARNING);
                }
            } else {
                formatReportFields("doorThicknessInput",
                    REPORT_FIELD.LOCK_DOOR_THICKNESS_INPUT.toUpperCase(),
                    lockAndDoorData.doorThicknessInput + " " +
                    REPORT_FIELD.LOCK_THICKNESS_MM);
                if (lockAndDoorData.doorThicknessInputMessage.trim().length > 0) {
                    formatReportFields("doorThicknessInputMessage",
                        REPORT_FIELD.LOCK_DOOR_THICKNESS_INPUT_MESSAGE.toUpperCase(),
                        lockAndDoorData.doorThicknessInputMessage, WARNING);
                }
            }
            formatReportFields("doorMaterial",
                REPORT_FIELD.LOCK_DOOR_MATERIAL.toUpperCase(),
                lockAndDoorData.doorMaterial);
            if (lockAndDoorData.doorMaterialMessage.trim().length > 0) {
                formatReportFields("doorMaterialMessage",
                    REPORT_FIELD.LOCK_DOOR_MATERIAL_MESSAGE.toUpperCase(),
                    lockAndDoorData.doorMaterialMessage, WARNING);
            }

            formatReportFields("doorLeaf",
                REPORT_FIELD.LOCK_DOOR_LEAF.toUpperCase(),
                lockAndDoorData.doorLeaf);
            if (lockAndDoorData.doorLeafMessage.trim().length > 0) {
                formatReportFields("doorLeafMessage",
                    REPORT_FIELD.LOCK_DOOR_LEAF_MESSAGE.toUpperCase(),
                    lockAndDoorData.doorLeafMessage, WARNING);
            }

        }

    } else if (page === "1") {
        // Redirect to the survey-report page page
        window.location.replace("./../html/lock-selection-survey.html");
    } else {
        // Redirect to the index page
        window.location.replace("./../html/index.html");
    }

}

/*****************************************************************************/
/* HELPER FUNCTIONS                                                          */
/*****************************************************************************/

/* The function adds the report field value <div> columns within the specific
 * row. 
 * @param    {HTMLElement} fieldDivId   The specific row <div> id.
 * @param    {REPORT_FIELD} labelName   Language specific label name.
 * @param    {String} labelValue    Label value.
 * @param    {String} message    "", WARNING or CAUTION class styling.
 * @return      
 * */
const formatReportFields = (fieldDivId, labelName, labelValue, message = NONE) => {

    // Get the specific row <div>
    let fieldDiv = document.getElementById(fieldDivId);

    // Create a label column <div>
    let labelNameDiv = document.createElement("div");
    labelNameDiv.setAttribute("class", "col-4 col-sm-4 col-md-5");

    // Create a <p> tag to hold the field label
    // and attach appropriate class style depending upon if it is a normal
    // field value row, a warning message row or a caution message row
    let label = document.createElement("p");
    if (message === WARNING) {
        label.setAttribute("class", "warning");
    } else if (message === CAUTION) {
        label.setAttribute("class", "caution");
    } else {
        label.setAttribute("class", "field-label");
    }

    // Set the label
    label.innerHTML = labelName;

    // Append the label <p> inside the label column <div>
    labelNameDiv.appendChild(label);
    fieldDiv.appendChild(labelNameDiv);

    // Create a value column <div>
    let labelValueDiv = document.createElement("div");
    labelValueDiv.setAttribute("class", "field-value col-8 col-sm-8 col-md-7");

    // Create a <p> tag to hold the field value
    // and attach appropriate class style depending upon if it is a normal
    // field value row, a warning message row or a caution message row
    let value = document.createElement("p");
    if (message === WARNING) {
        value.setAttribute("class", "warning");
    } else if (message === CAUTION) {
        value.setAttribute("class", "caution");
    }

    // Set the value
    value.innerHTML = labelValue;

    // Append the value <p> inside the value column <div>
    labelValueDiv.appendChild(value);
    fieldDiv.appendChild(labelValueDiv);

}

/* The function creates a pdf file for the report.
 *  
 * @param
 * @return      
 * */
const createPDF = () => {

    // Get the parent <div> element for the report
    let element = document.getElementById('report-body');

    // Configure the pdf
    let option = {
        margin: [0.50, 0.25, 0.25, 0.25],
        filename: JSON.parse(sessionStorage.getItem("customerData"))
            .customerMobile + '.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: window.devicePixelRatio
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    // Create the pdf and provide an option to save it
    html2pdf().set(option).from(element).save();

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/