"use strict";

/* * JavaScript for the file index.html
 *  @author Sanket Rajgarhia
 *  @date   30/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* GLOBAL CONSTANTS                                                          */
/*****************************************************************************/

const LANGUAGE = {
    ENGLISH: 'EN',
    THAI: 'ไทย'
};

/*****************************************************************************/
/* GLOBAL VARIABLES                                                          */
/*****************************************************************************/

// Global variable for language
let language = LANGUAGE.ENGLISH;

/*****************************************************************************/
/* GLOBAL FUNCTIONS                                                          */
/*****************************************************************************/

/* This function creates a <script> tag with src and type attribute and 
 * attaches it to the body element.
 * @param    {string} src  The relative path of the script file.
 * @return   
 * */
function loadScript(src) {

    let element = document.createElement("script");
    element.src = src;
    element.type = "text/javascript"
    document.body.appendChild(element);

}

/* This function changes the value of the global variable for language.
 * @param    {Unicode String} language  The selected language.
 * @return   
 * */
const changeLanguage = (language) => {

    switch (language) {
        case LANGUAGE.ENGLISH:
            language = LANGUAGE.ENGLISH
            break;
        case LANGUAGE.THAI:
            language = LANGUAGE.THAI;
            break;
        default:
            language = LANGUAGE.ENGLISH
            break;
    }

    sessionStorage.removeItem("page");
    sessionStorage.removeItem("lockModelSelected");
    sessionStorage.removeItem("lockAndDoorData");
    sessionStorage.removeItem("compatibleDoor");

    sessionStorage.setItem("LANGUAGE", language);
    location.reload();

};

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/