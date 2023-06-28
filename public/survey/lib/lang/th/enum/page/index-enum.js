"use strict";

/* * JavaScript for the file index.html
 *  @author Sanket Rajgarhia
 *  @date   22/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: th
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS (TH)                                          */
/*****************************************************************************/

// index page title (TH)
const INDEX = {
    TITLE: "แบบสำรวจการเลือกรุ่นล็อคและสเปคประตูของลูกค้า",
};

// Lock selection card
const LOCK_SELECTION_CARD = {
    HEADER: "กรุณเลือกล็อคที่ท่านต้องการ",
    LABEL_LOCK_MODEL: "ค้นหาล็อคที่ต้องการจากแถบเมนูนี้",
    SUITABILITY_MESSAGE: "ล็อคนี้เหมาะสำหรับประเภทประตูต่อไปนี้",
    LABEL_DOOR_TYPE: "ประเภทประตู : ",
    LABEL_DOOR_THICKNESS: "ช่วงความหนาของประตู : ",
};

// Door specification card
const DOOR_SPECIFICATION_CARD = {
    HEADER: "เลือกขนาดประตู และรุ่นล็อคด้วยตนเอง",
    PROCEED_MESSAGE: `คลิกที่ปุ่ม ` +
        `<span id="label-next" class="highlight-text"></span> ` +
        `และระบุข้อกำหนดของประตูเพื่อตรวจสอบความเหมาะสมของรุ่นล็อคกับประตูของท่าน`,

    LABEL_NEXT: "ถัดไป",
};

// Navigation buttons
const NAVIGATION_BUTTONS = {
    SELECT_BUTTON: "     เลือก     ",
    NEXT_BUTTON: "      ถัดไป      "
};

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(INDEX);
Object.freeze(LOCK_SELECTION_CARD);
Object.freeze(DOOR_SPECIFICATION_CARD);
Object.freeze(NAVIGATION_BUTTONS);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/