'use strict';

/* * The Message Enumeration Values (TH).
 *  @author   Sanket Rajgarhia
 *  @date 05/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: th
 * */

/*****************************************************************************/
/* MESSAGE ENUMERATION (TH)                                                  */
/*****************************************************************************/

// Messages
const MESSAGE = {
    MESSAGE_FAILURE: "ขออภัย ไม่สามารถติดตั้งล็อคที่เลือกได้",
    MESSAGE_DOOR_TYPE_AND_LOCK_MISMATCH: "ประเภทของประตู ไม่เหมาะกับล็อครุ่นนี้ กรุณาเลือกล็อครุ่นอื่นแทน",
    MESSAGE_JAMB_AND_LOCK_TYPE_MISMATCH: "ไม่แนะนำให้ใช้ล็อครุ่นนี้กับประตูบานคู่",
    MESSAGE_DOOR_THICKNESS_AND_LOCK_MISMATCH: "ไม่สามารถติดตั้งล็อคกับความหนาประตูนี้ได้",
    MESSAGE_MATERIAL_FAILURE: "วัสดุของประตูไม่สามารถติดตั้งล็อครุ่นนี้ได้",
    MESSAGE_DOOR_LEAF_AND_DOOR_TYPE_MISMATCH: "ไม่สามารถติดตั้งล็อคกับกรอบบานนี้ได้",
    MESSAGE_DOOR_LEAF_FRAME_THICKNESS_INADEQUATE: "ไม่สามารถติดตั้งล็อคกับกรอบบานเปิดนี้ได้",
    MESSAGE_DOOR_LEAF_THICKNESS_INADEQUATE: "ไม่สามารถติดตั้งล็อคกับกรอบบานเลื่อนนี้ได้",

    MESSAGE_MISSING_INPUT: "กรุณากรอกข้อมูลในช่องแดงให้ครบถ้วน"
}

// Caution messages
const CAUTION = {
    EXISTING_DOOR_RETROFIT_CAUTION: "หมายเหตุ :\n" +
        "ล็อคอาจะปิดรูเจาะเดิมไม่หมด ช่างติดตั้งจะทำการอุดรูเจาะเดิมที่บานประตู ด้วย ซิลิโคน หรือวัสดุอื่นๆ",
    EXISTING_DOOR_RETROFIT_RIM_LOCK_CAUTION: "หมายเหตุ: \n" +
        "ล็อครุ่นนี้จะติดเสริมมือจับประตูเดิมที่ด้านบน",
    SWING_DOOR_JAMB_CAUTION: "หมายเหตุ: \n" +
        "ช่างติดตั้งอาจจะต้องทำการตัด เซาะ จุดที่จะต้องติดตั้งอุปกรณ์เพื่อให้ล็อคทำงานได้ดีที่สุด",
    DOOR_MATERIAL_CAUTION: "หมายเหตุ: \n" +
	"สำหรับประตูเหล็กลูกค้าจะต้องให้ช่างประตูเจาะประตูตามแบบเจาะมาให้ก่อน ทีมช่าง Hafele จะเป็นผู้รับผิดชอบในส่วนของการประกอบติดตั้งและสอนการตั้งค่าให้เท่านั้น "
}

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(MESSAGE);
Object.freeze(CAUTION);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/