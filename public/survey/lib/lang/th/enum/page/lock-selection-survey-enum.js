"use strict";

/* * JavaScript for the file survey-report.html
 *  @author Sanket Rajgarhia
 *  @date   17/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: th
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS (TH)                                          */
/*****************************************************************************/

// Lock selection survey (TH)
const LOCK_SELECTION_SURVEY = {
    TITLE: "Lock Selection Survey",
    PAGE_HEADING: "แบบสำรวจการเลือกรุ่นล็อกและสเปคประตูของลูกค้า",

    LOCK_CARD_HEADING: "ข้อมูลประตูและล็อก",
    LOCK_MODEL: "กรุณาเลือกรุ่นล็อก",
    LOCK_INSTALLATION_LOCATION: "สภาพแวดล้อมที่จะติดตั้ง",
    LOCK_DOOR_CONDITION: "ประตูที่จะติดตั้ง",
    LOCK_DOOR_RETROFIT: "ประเภทของล็อกที่มีการติดตั้งไว้แล้ว",
    LOCK_DOOR_TYPE: "ประเภทประตูตามวิธีการเปิด",
    LOCK_SWING_DOOR_TYPE: "บานเปิดเข้า/ออก ทางเดียว",
    LOCK_SWING_DOOR_JAMB: "ชนิดของวงกบ",
    LOCK_DOOR_THICKNESS: "ช่วงความหนาบานประตู",
    LOCK_DOOR_THICKNESS_INPUT: "กรุณากรอกความหนาในหน่วยมิลลิเมตร (มม.)",
    LOCK_DOOR_MATERIAL: "วัสดุของประตู",
    LOCK_DOOR_LEAF: "ชนิดบานประตูและความกว้างกรอบบาน",

    LOCK_DOOR_LEAF_GROUP_LABEL_START: "",
    LOCK_DOOR_LEAF_GROUP_LABEL_SWING_DOOR: "บานเปิดเข้า/ออก ทางเดียว",
    LOCK_DOOR_LEAF_GROUP_LABEL_SLIDING_DOOR: "บานเลื่อน",

    CUSTOMER_CARD_HEADING: "ข้อมูลของลูกค้า",
    CUSTOMER_NAME_PLACEHOLDER: "ชื่อ-นามสกุล ลูกค้า",
    CUSTOMER_NAME_INVALID_MESSAGE_FEEDBACK: "กรุณาใส่ชื่อและนามสกุล",
    CUSTOMER_NAME_LENGTH_INVALID_MESSAGE_FEEDBACK: "ไม่สามารถใส่ชื่อและนามสกุล " +
        "ได้เกิน 50 ตัวอักษร",
    CUSTOMER_MOBILE_PLACEHOLDER: "เบอร์มือถือลูกค้า",
    CUSTOMER_MOBILE_INVALID_MESSAGE_FEEDBACK: "กรุณาใส่เบอร์มือถือลูกค้าที่ติดต่อได้",
    CUSTOMER_MOBILE_DIGITS_INVALID_MESSAGE_FEEDBACK: "เบอร์มือถือจะต้องประกอบด้วย " +
        "ตัวเลข 10 หลัก และขึ้นต้นด้วย 0",
    CUSTOMER_ADDRESS1_PLACEHOLDER: "กรุณใส่ที่อยู่ที่ต้องการติดตั้งล็อก - แถวที่ 1",
    CUSTOMER_ADDRESS1_INVALID_MESSAGE_FEEDBACK: "กรุณใส่ที่อยู่ที่ต้องการติดตั้งล็อก",
    CUSTOMER_ADDRESS1_LENGTH_INVALID_MESSAGE_FEEDBACK: "ไม่สามารถใส่ตัวอักษรได้เกิน 50 ตัว " +
        "กรุณาใส่ต่อในแถวถัดไป",
    CUSTOMER_ADDRESS2_PLACEHOLDER: "กรุณใส่ที่อยู่ที่ต้องการติดตั้งล็อก - แถวที่ 2",
    CUSTOMER_ADDRESS2_INVALID_MESSAGE_FEEDBACK: "ไม่สามารถใส่ตัวอักษรได้เกิน 50 ตัว " +
        "กรุณาใส่ต่อในแถวถัดไป",
    CUSTOMER_ADDRESS3_PLACEHOLDER: "กรุณใส่ที่อยู่ที่ต้องการติดตั้งล็อก - แถวที่ 3",
    CUSTOMER_ADDRESS3_INVALID_MESSAGE_FEEDBACK: "ไม่สามารถใส่ตัวอักษรได้เกิน 50 ตัว " +
        "กรุณาใส่ต่อในแถวถัดไป",
    CUSTOMER_ADDITIONAL_INFORMATION_PLACEHOLDER: "ข้อมูลเพิ่มเติม เช่น จุดสังเกตุของบ้าน ฯลฯ ",
    CUSTOMER_ADDITIONAL_INFORMATION_INVALID_MESSAGE_FEEDBACK: "ข้อมูลเพิ่มเติมนี้ " +
        "ไม่สามารถใส่ตัวอักษรได้เกิน 250 ตัว.",

    SALES_PERSON_CARD_HEADING: "ข้อมูลพนักงานตัวแทนขาย",
    SALES_PERSON_ID_PLACEHOLDER: "รหัสพนักงานขาย	",
    SALES_PERSON_ID_INVALID_MESSAGE_FEEDBACK: "กรุณาใส่รหัสพนักงานขาย",
    SALES_PERSON_ID_LENGTH_INVALID_MESSAGE_FEEDBACK: "รหัสพนักงานขาย " +
        " ไม่สามารถใส่ได้เกิน 50 ตัวอักษร",
    SALES_PERSON_NAME_PLACEHOLDER: "ชื่อ-สกุล พนักงานขาย",
    SALES_PERSON_NAME_INVALID_MESSAGE_FEEDBACK: "กรุณาใส่ ชื่อ-สกุล พนักงานขาย",
    SALES_PERSON_NAME_LENGTH_INVALID_MESSAGE_FEEDBACK: "ชื่อ-สกุล พนักงานขาย " +
        "ไม่สามารถใส่ได้เกิน 50 ตัวอักษร",
    SALES_PERSON_LOCATION_PLACEHOLDER: "สถานที่,ห้างร้าน - สาขาที่ขายล็อก",
    SALES_PERSON_LOCATION_INVALID_MESSAGE_FEEDBACK: "ไม่สามารถ " +
        "ใส่ข้อมูลได้เกิน 150 ตัวอักษร"

};

// Navigation buttons
const NAVIGATION_BUTTONS = {
    LOCK_PREVIOUS_BUTTON: "    กลับไป    ",
    LOCK_NEXT_BUTTON: "      ต่อไป      "
}

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(LOCK_SELECTION_SURVEY);
Object.freeze(NAVIGATION_BUTTONS);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/