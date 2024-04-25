"use strict";

/* * JavaScript for the file survey-report.html
 *  @author Sanket Rajgarhia
 *  @date   09/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language th
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS (TH)                                          */
/*****************************************************************************/

// Report title (TH)
const SURVEY_REPORT = {
    TITLE: "Lock Selection Survey Report",
    PAGE_HEADING: "แบบสำรวจการเลือกรุ่นล็อกและสเปคประตูของลูกค้า",
    REPORT_TITLE: "ข้อมูลลูกค้าและข้อมูลพนักงานขาย",

    PRINT_BUTTON: "  พิมพ์  <span class=\"sr-only\">(current)</span>",
    DOWNLOAD_BUTTON: "ดาวน์โหลด ",
    EMAIL_BUTTON : "ส่งเมล"

};

/*****************************************************************************/
/* REPORT_FIELDS ENUMERATIONS                                               */
/*****************************************************************************/

// Report Field labels (EN)
const REPORT_FIELD = {
    CUSTOMER_NAME: "ชื่อลูกค้า",
    CUSTOMER_MOBILE: "เบอร์มือถือลูกค้า",
    CUSTOMER_ADDRESS: "ที่อยู่ลูกค้า",
    CUSTOMER_INFORMATION: "รายละเอียดเพิ่มเติม",

    SALES_PERSON_ID: "รหัสพนักงานขาย",
    SALES_PERSON_NAME: "ชื่อพนักงานขาย",
    SALES_PERSON_LOCATION: "สถานที่,ห้างร้าน - สาขาที่ขายล็อก",

    SURVEY_DETAILS: "ข้อมูลประตูและล็อกที่จะติดตั้ง",

    LOCK_MODEL: "รุ่นโมเดลล็อก",
    LOCK_INSTALLATION_LOCATION: "สภาพแวดล้อมที่จะติดตั้ง",
    LOCK_INSTALLATION_LOCATION_MESSAGE: "",
    LOCK_DOOR_CONDITION: "ประตูที่จะติดตั้ง",
    LOCK_DOOR_CONDITION_MESSAGE: "",
    LOCK_DOOR_RETROFIT: "บานประตูเดิมที่มีการติดตั้งมือจับมาแล้ว",
    LOCK_DOOR_RETROFIT_MESSAGE: "",
    LOCK_DOOR_RETROFIT_CAUTION: "",
    LOCK_DOOR_TYPE: "ประเภทประตูตามวิธีการเปิด",
    LOCK_DOOR_TYPE_MESSAGE: "",
    LOCK_SWING_DOOR_TYPE: "บานเปิดเข้า - ออก ทางเดียว",
    LOCK_SWING_DOOR_TYPE_MESSAGE: "",
    LOCK_SWING_DOOR_JAMB: "ชนิดของวงกบ",
    LOCK_SWING_DOOR_JAMB_MESSAGE: "",
    LOCK_SWING_DOOR_JAMB_CAUTION: "",
    LOCK_DOOR_THICKNESS: "ความหนาบานประตู",
    LOCK_DOOR_THICKNESS_MESSAGE: "",
    LOCK_DOOR_THICKNESS_INPUT: "ความหนาบานประตู",
    LOCK_DOOR_THICKNESS_INPUT_MESSAGE: "",
    LOCK_THICKNESS_MM: "มม.",
    LOCK_DOOR_MATERIAL: "วัสดุของประตู",
    LOCK_DOOR_MATERIAL_MESSAGE: "",
    LOCK_DOOR_MATERIAL_CAUTION: "",
    LOCK_DOOR_LEAF: "ชนิดบานประตูและความกว้างกรอบบาน",
    LOCK_DOOR_LEAF_MESSAGE: ""
};

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(SURVEY_REPORT);
Object.freeze(REPORT_FIELD);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/