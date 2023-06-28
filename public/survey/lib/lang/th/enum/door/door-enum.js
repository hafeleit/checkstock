'use strict';

/* * The Door Enumeration Values (TH).
 *  @author   Sanket Rajgarhia
 *  @date 31/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: th
 * */

/*****************************************************************************/
/* DOOR ENUMERATION (TH)                                                     */
/*****************************************************************************/

/* Door Material specification */
const DOOR_MATERIAL = {
    WOOD: "ไม้",
    GLASS: "กระจกเปลือย",
    STEEL: "เหล็ก",
    ALUMINIUM: "อะลูมิเนียม",
    PVC: "พลาสติกPVC",
    UPVC: "UPVC",
    WPC: "WPC"
};

/* Door Condition Specification */
const DOOR_CONDITION = {
    INSTALLED: "บานประตูเดิมที่มีการติดตั้งมือจับมาแล้ว",
    NEW: "บานประตูใหม่ ไม่เคยติดตั้งมือจับมาก่อน"
}

/* Door Installation Location */
const DOOR_INSTALLATION_LOCATION = {
    INDOOR: "ติดตั้งภายในร่ม",
    OUTDOOR_PROTECTED: "ติดตั้งภายนอก (มีการป้องกันจากน้ำฝนและแดดจัด)",
    OUTDOOR_EXPOSED: "ติดตั้งภายนอก (ถูกน้ำฝนและแสงแดดโดยตรง)",
    GARAGE_DOOR_EXAMPLE: "GARAGE DOOR"
}

/* Thickness of the door */
const DOOR_THICKNESS_IN_MM = {
    MM_30_TO_50: "30-50 มม.",
    MM_32_TO_50: "32-50 มม.",
    MM_35_TO_50: "35-50 มม.",
    MM_35_TO_60: "35-60 มม.",
    MM_35_TO_90: "35-90 มม.",
    MM_OTHER: "กรอกความหนาที่วัดได้ "
}

/* Door Type */
const DOOR_TYPE = {
    SLIDING_DOOR: "บานเลื่อน",
    SWING_DOOR: "บานเปิดเข้า - ออก ทางเดียว"
}

/* Swing Door Type */
const SWING_DOOR_TYPE = {
    SWING_DOOR_SINGLE: "ประตูบานเดี่ยว",
    SWING_DOOR_DOUBLE: "ประตูบานคู่"
}

/* Swing Door Jamb */
const SWING_DOOR_JAMB = {
    FLUSH_DOOR: "แบบไม่มีซับวงกบ",
    REBATED_DOOR: "แบบมีซับวงกบ",
    DOUBLE_LEAF_DOOR: "แบบประตูบานคู่(บานฟิกซ์)"
}

/* Door Retrofit */
const DOOR_RETROFIT = {
    LEVER_HANDLE: "ติดตั้งชุดล็อคระบบมอทิส",
    KNOB: "ติดตั้งชุดล็อคลูกบิดหรือลูกบิดก้านโยก",
    GRIP: "ติดตั้งชุดล็อค Grip Handle"
}

/* Swing Door Leaf Types */
const SWING_DOOR_LEAF = {
    PLAIN_LEAF: "บานประตูแบบเรียบทั้งบาน",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_50_MM: "บานประตูมีลูกฟัก กรอบบานกว้างน้อยกว่า 50 มม.",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_50_MM: "บานประตูมีลูกฟัก กรอบบานกว้างมากกว่า 50 มม.",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_60_MM: "บานประตูมีลูกฟัก กรอบบานกว้างน้อยกว่า 60 มม.",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_60_MM: "บานประตูมีลูกฟัก กรอบบานกว้างมากกว่า 60 มม.",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_100_MM: "บานประตูมีลูกฟัก กรอบบานกว้างน้อยกว่า 100 มม.",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_100_MM: "บานประตูมีลูกฟัก กรอบบานกว้างมากกว่า 100 มม.",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_130_MM: "บานประตูมีลูกฟัก กรอบบานกว้างน้อยกว่า 130 มม.",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_130_MM: "บานประตูมีลูกฟัก กรอบบานกว้างมากกว่า 130 มม.",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_50_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างน้อยกว่า 50 มม.",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_50_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างมากกว่า 50 มม.",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_60_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างน้อยกว่า 60 มม.",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_60_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างมากกว่า 60 มม.",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_100_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างน้อยกว่า 100 มม.",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_100_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างมากกว่า 100 มม.",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_130_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างน้อยกว่า 130 มม.",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_130_MM: "ประตูกระจกมีกรอบบาน กรอบบานกว้างมากกว่า 130 มม."
}

/* Sliding Door Leaf Types */
const SLIDING_DOOR_LEAF = {
    PLAIN_LEAF: "บานประตูแบบเรียบทั้งบาน",

    WOODEN_LEAF_LESS_THAN_50_MM: "ประตูกระจกกรอบบานไม้ กรอบบานกว้างน้อยกว่า 50 มม.",
    WOODEN_LEAF_EQUAL_OR_MORE_THAN_50_MM: "ประตูกระจกกรอบบานไม้ กรอบบานกว้างมากกว่า 50 มม.",

    ALUMINIUM_LEAF_LESS_THAN_50_MM: "ประตูกระจกกรอบบานอะลูมิเนียม กรอบบานกว้างน้อยกว่า 50 มม.",
    ALUMINIUM_LEAF_EQUAL_OR_MORE_THAN_50_MM: "ประตูกระจกกรอบบานอะลูมิเนียม กรอบบานกว้างมากกว่า 50 มม.",

    STEEL_LEAF_LESS_THAN_50_MM: "ประตูกระจกกรอบบานเหล็ก กรอบบานกว้างน้อยกว่า 50 มม.",
    STEEL_LEAF_EQUAL_OR_MORE_THAN_50_MM: "ประตูกระจกกรอบบานเหล็ก กรอบบานกว้างมากกว่า 50 มม."
}

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(DOOR_MATERIAL);
Object.freeze(DOOR_CONDITION);
Object.freeze(DOOR_INSTALLATION_LOCATION);
Object.freeze(DOOR_THICKNESS_IN_MM);
Object.freeze(DOOR_TYPE);
Object.freeze(SWING_DOOR_TYPE);
Object.freeze(SWING_DOOR_JAMB);
Object.freeze(DOOR_RETROFIT);
Object.freeze(SWING_DOOR_LEAF);
Object.freeze(SLIDING_DOOR_LEAF);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/