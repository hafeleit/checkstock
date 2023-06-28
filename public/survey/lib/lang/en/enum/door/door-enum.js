'use strict';

/* * The Door Enumeration Values (EN).
 *  @author   Sanket Rajgarhia
 *  @date 31/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: en
 * */

/*****************************************************************************/
/* DOOR ENUMERATION (EN)                                                     */
/*****************************************************************************/

/* Door Material specification */
const DOOR_MATERIAL = {
    WOOD: "WOOD",
    GLASS: "GLASS",
    STEEL: "STEEL",
    ALUMINIUM: "ALUMINIUM",
    PVC: "PVC",
    UPVC: "UPVC",
    WPC: "WPC"
};

/* Door Condition Specification */
const DOOR_CONDITION = {
    INSTALLED: "EXISTING",
    NEW: "NEW"
}

/* Door Installation Location */
const DOOR_INSTALLATION_LOCATION = {
    INDOOR: "INDOOR",
    OUTDOOR_PROTECTED: "OUTDOOR PROTECTED (FROM WATER AND STRONG SUNLIGHT)",
    OUTDOOR_EXPOSED: "OUTDOOR EXPOSED (TO WATER AND SUNLIGHT)",
    GARAGE_DOOR_EXAMPLE: "GARAGE DOOR"
}

/* Thickness of the door */
const DOOR_THICKNESS_IN_MM = {
    MM_30_TO_50: "30-50 mm",
    MM_32_TO_50: "32-50 mm",
    MM_35_TO_50: "35-50 mm",
    MM_35_TO_60: "35-60 mm",
    MM_35_TO_90: "35-90 mm",
    MM_OTHER: "OTHER"
}

/* Door Type */
const DOOR_TYPE = {
    SLIDING_DOOR: "SLIDING DOOR",
    SWING_DOOR: "SWING DOOR"
}

/* Swing Door Type */
const SWING_DOOR_TYPE = {
    SWING_DOOR_SINGLE: "SINGLE DOOR",
    SWING_DOOR_DOUBLE: "DOUBLE DOOR"
}

/* Swing Door Jamb */
const SWING_DOOR_JAMB = {
    FLUSH_DOOR: "FLUSH DOOR",
    REBATED_DOOR: "REBATED DOOR",
    DOUBLE_LEAF_DOOR: "DOUBLE LEAF DOOR"
}

/* Door Retrofit */
const DOOR_RETROFIT = {
    LEVER_HANDLE: "DOOR WITH LEVER HANDLE SET",
    KNOB: "DOOR WITH KNOB LOCK SET",
    GRIP: "DOOR WITH GRIP HANDLE"
}

/* Swing Door Leaf Types */
const SWING_DOOR_LEAF = {
    PLAIN_LEAF: "PLAIN LEAF",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_50_MM: "DOOR LEAF WITH MULLION < 50 mm",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_50_MM: "DOOR LEAF WITH MULLION >= 50 mm",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_60_MM: "DOOR LEAF WITH MULLION < 60 mm",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_60_MM: "DOOR LEAF WITH MULLION >= 60 mm",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_100_MM: "DOOR LEAF WITH MULLION < 100 mm",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_100_MM: "DOOR LEAF WITH MULLION >= 100 mm",

    DOOR_LEAF_WITH_MULLION_LESS_THAN_130_MM: "DOOR LEAF WITH MULLION < 130 mm",
    DOOR_LEAF_WITH_MULLION_EQUAL_OR_MORE_THAN_130_MM: "DOOR LEAF WITH MULLION >= 130 mm",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_50_MM: "DOOR LEAF WITH FRAME < 50 mm",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_50_MM: "DOOR LEAF WITH FRAME >= 50 mm",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_60_MM: "DOOR LEAF WITH FRAME < 60 mm",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_60_MM: "DOOR LEAF WITH FRAME >= 60 mm",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_100_MM: "DOOR LEAF WITH FRAME < 100 mm",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_100_MM: "DOOR LEAF WITH FRAME >= 100 mm",

    DOOR_LEAF_WITH_FRAME_LESS_THAN_130_MM: "DOOR LEAF WITH FRAME < 130 mm",
    DOOR_LEAF_WITH_FRAME_EQUAL_OR_MORE_THAN_130_MM: "DOOR LEAF WITH FRAME >= 130 mm"
}

/* Sliding Door Leaf Types */
const SLIDING_DOOR_LEAF = {
    PLAIN_LEAF: "PLAIN LEAF",

    WOODEN_LEAF_LESS_THAN_50_MM: "WOODEN LEAF < 50 mm",
    WOODEN_LEAF_EQUAL_OR_MORE_THAN_50_MM: "WOODEN LEAF >= 50 mm",

    ALUMINIUM_LEAF_LESS_THAN_50_MM: "ALUMINIUM LEAF < 50 mm",
    ALUMINIUM_LEAF_EQUAL_OR_MORE_THAN_50_MM: "ALUMINIUM LEAF >= 50 mm",

    STEEL_LEAF_LESS_THAN_50_MM: "STEEL LEAF < 50 mm",
    STEEL_LEAF_EQUAL_OR_MORE_THAN_50_MM: "STEEL LEAF >= 50 mm"
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