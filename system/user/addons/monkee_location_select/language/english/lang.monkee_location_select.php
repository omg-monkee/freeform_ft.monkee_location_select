<?php

/**
 * Monk-ee Location Select - Language
 */

$lang = array(
//Field Info
'monkloc_default_field_name' => "Monk-ee Location Select",
'monkloc_default_field_desc' => "Modified version of the default Location Select fieldtypes (State Select, Country Select, etc).",
'monkloc_default_field_type' => "monkee_location_select",

//Settings
'monkloc_field_content_type' => "List Content Type",
'monkloc_field_content_type_desc' => "Select the type of information to populate the option list with.",
'monkloc_blank_line' => "Insert Blank Option",
'monkloc_blank_line_desc' => "Check this box to add a blank line option to the top of the select box. This will be the default option if no value is entered in the Default Option box below.",
'monkloc_default_value' => "Default Values",
'monkloc_default_value_desc' => "Select a default option for each of the list types. If form data is not being edited or there is no saved data, this option will be selected by default for each list type. NOTE: Setting the inline 'default_value' parameter will override these settings.",
'monkloc_enable_autofocus' => "Enable Autofocus",
'monkloc_enable_autofocus_desc' => "Field will automatically be selected on page load. If multiple fields on a form have this property enabled, the field loaded first will claim control.",
'monkloc_enable' => "Enable",
'monkloc_field_title' => "Populate Title Parameter",
'monkloc_field_title_desc' => "Select if and how you want to populate the title field in the input tag. This is useful for displaying tooltips. NOTE: Setting the inline 'attr:title' parameter will override these settings.",
'monkloc_field_none' => "None",
'monkloc_field_label' => "Field Label",
'monkloc_field_desc' => "Field Description",
'monkloc_field_custom' => "Custom",
'monkloc_field_title_custom' => "Enter custom title here",
'monkloc_css_classes' => "CSS Classes",
'monkloc_css_classes_desc' => "Output as many classes as you like. The checkboxes will add dynamic information as classes. Enter any custom classes in the text box. NOTE: Setting the inline 'attr:class' parameter will override these settings. For List Content Type, US States -> states, Canadian Provinces -> provinces, UK Counties -> ukcounties, Countries -> countries. Field Name pulls from the Field Name value shown above. Freeform Field Type will output 'monkee_location_select'",
'monkloc_css_content' => "List Content Type",
'monkloc_css_name' => "Field Name",
'monkloc_css_type' => "Freeform Field Type",
'monkloc_css_custom' => "Enter custom css styles here",
'monkloc_custom_params' => "Custom Parameters",
'monkloc_custom_params_desc' => "Enter custom parameters and values here. Values not required. These will be added to the field tag.",
'monkloc_custom_place' => "Parameter",
'monkloc_custom_value' => "Value",
'monkloc_js_event' => "Custom Javascript/jQuery Event",
'monkloc_js_event_desc' => "For advanced users only. Select a javascript event from the dropdown box. Then, in the textbox, enter the javascript (or jQuery) you would like to attach to this event. <b>PLEASE NOTE: Because of the way Freeform handles field entry on this page, you must escape parentheses with a backslash. Failing to do this will result in this form not saving. Also, DO NOT USE DOUBLE QUOTES, only single quotes. Ex: alert&#92;('test'&#92;);.</b> <a href='http://www.w3schools.com/jsref/dom_obj_event.asp' target='_blank'>Click here to view a list of javascript events and descriptions.</a> NOTE: Setting the inline 'attr:onclick' parameter will override an onclick action setup here.",
'monkloc_js_action' => "Enter JavaScript/jQuery action here",
'monkloc_js_confirm' => "I confirm that I am an advanced user and have read the instructions.",

//Content Types
'states' => "US States",
'provinces' => "Canadian Provinces",
'ukcounties' => "UK Counties",
'countries' => "Countries",

// -------------------------------------
//	State, Province and County list last because
// 	its stupid long
// -------------------------------------

'list_of_us_states' => "
Alabama (AL)
Alaska (AK)
Arizona (AZ)
Arkansas (AR)
California (CA)
Colorado (CO)
Connecticut (CT)
Delaware (DE)
District of Columbia (DC)
Florida (FL)
Georgia (GA)
Guam (GU)
Hawaii (HI)
Idaho (ID)
Illinois (IL)
Indiana (IN)
Iowa (IA)
Kansas (KS)
Kentucky (KY)
Louisiana (LA)
Maine (ME)
Maryland (MD)
Massachusetts (MA)
Michigan (MI)
Minnesota (MN)
Mississippi (MS)
Missouri (MO)
Montana (MT)
Nebraska (NE)
Nevada (NV)
New Hampshire (NH)
New Jersey (NJ)
New Mexico (NM)
New York (NY)
North Carolina (NC)
North Dakota (ND)
Ohio (OH)
Oklahoma (OK)
Oregon (OR)
Pennsylvania (PA)
Puerto Rico (PR)
Rhode Island (RI)
South Carolina (SC)
South Dakota (SD)
Tennessee (TN)
Texas (TX)
Utah (UT)
Vermont (VT)
Virginia (VA)
Virgin Islands (VI)
Washington (WA)
West Virginia (WV)
Wisconsin (WI)
Wyoming (WY)",

'list_of_canadian_provinces' => "
Alberta (AB)
British Columbia (BC)
Manitoba (MB)
New Brunswick (NB)
Newfoundland and Labrador (NL)
Northwest Territories (NT)
Nova Scotia (NS)
Nunavut (NU)
Ontario (ON)
Prince Edward Island (PE)
Quebec (QC)
Saskatchewan (SK)
Yukon (YT)",

'list_of_uk_counties' => "
Aberdeenshire (ABD)
Anglesey (AGY)
Alderney (ALD)
Angus (ANS)
Co. Antrim (ANT)
Argyllshire (ARL)
Co. Armagh (ARM)
Avon (AVN)
Ayrshire (AYR)
Banffshire (BAN)
Bedfordshire (BDF)
Berwickshire (BEW)
Buckinghamshire (BKM)
Borders (BOR)
Breconshire (BRE)
Berkshire (BRK)
Bute (BUT)
Caernarvonshire (CAE)
Caithness (CAI)
Cambridgeshire (CAM)
Co. Carlow (CAR)
Co. Cavan (CAV)
Central (CEN)
Cardiganshire (CGN)
Cheshire (CHS)
Co. Clare (CLA)
Clackmannanshire (CLK)
Cleveland (CLV)
Cumbria (CMA)
Carmarthenshire (CMN)
Cornwall (CON)
Co. Cork (COR)
Cumberland (CUL)
Clwyd (CWD)
Derbyshire (DBY)
Denbighshire (DEN)
Devon (DEV)
Dyfed (DFD)
Dumfries-shire (DFS)
Dumfries and Galloway (DGY)
Dunbartonshire (DNB)
Co. Donegal (DON)
Dorset (DOR)
Co. Down (DOW)
Co. Dublin (DUB)
Co. Durham (DUR)
East Lothian (ELN)
East Riding of Yorkshire (ERY)
Essex (ESS)
Co. Fermanagh (FER)
Fife (FIF)
Flintshire (FLN)
Co. Galway (GAL)
Glamorgan (GLA)
Gloucestershire (GLS)
Grampian (GMP)
Gwent (GNT)
Guernsey (GSY)
Greater Manchester (GTM)
Gwynedd (GWN)
Hampshire (HAM)
Herefordshire (HEF)
Highland (HLD)
Hertfordshire (HRT)
Humberside (HUM)
Huntingdonshire (HUN)
Hereford and Worcester (HWR)
Inverness-shire (INV)
Isle of Wight (IOW)
Jersey (JSY)
Kincardineshire (KCD)
Kent (KEN)
Co. Kerry (KER)
Co. Kildare (KID)
Co. Kilkenny (KIK)
Kirkcudbrightshire (KKD)
Kinross-shire (KRS)
Lancashire (LAN)
Co. Londonderry (LDY)
Leicestershire (LEI)
Co. Leitrim (LET)
Co. Laois (LEX)
Co. Limerick (LIM)
Lincolnshire (LIN)
Lanarkshire (LKS)
Co. Longford (LOG)
Co. Louth (LOU)
Lothian (LTN)
Co. Mayo (MAY)
Co. Meath (MEA)
Merionethshire (MER)
Mid Glamorgan (MGM)
Montgomeryshire (MGY)
Midlothian (MLN)
Co. Monaghan (MOG)
Monmouthshire (MON)
Morayshire (MOR)
Merseyside (MSY)
Nairn (NAI)
Northumberland (NBL)
Norfolk (NFK)
North Riding of Yorkshire (NRY)
Northamptonshire (NTH)
Nottinghamshire (NTT)
North Yorkshire (NYK)
Co. Offaly (OFF)
Orkney (OKI)
Oxfordshire (OXF)
Peebles-shire (PEE)
Pembrokeshire (PEM)
Perth (PER)
Powys (POW)
Radnorshire (RAD)
Renfrewshire (RFW)
Ross and Cromarty (ROC)
Co. Roscommon (ROS)
Roxburghshire (ROX)
Rutland (RUT)
Shropshire (SAL)
Selkirkshire (SEL)
Suffolk (SFK)
South Glamorgan (SGM)
Shetland (SHI)
Co. Sligo (SLI)
Somerset (SOM)
Sark (SRK)
Surrey (SRY)
Sussex (SSX)
Strathclyde (STD)
Stirlingshire (STI)
Staffordshire (STS)
Sutherland (SUT)
East Sussex (SXE)
West Sussex (SXW)
South Yorkshire (SYK)
Tayside (TAY)
Co. Tipperary (TIP)
Tyne and Wear (TWR)
Co. Tyrone (TYR)
Warwickshire (WAR)
Co. Waterford (WAT)
Co. Westmeath (WEM)
Westmorland (WES)
Co. Wexford (WEX)
West Glamorgan (WGM)
Co. Wicklow (WIC)
Wigtownshire (WIG)
Wiltshire (WIL)
Western Isles (WIS)
West Lothian (WLN)
West Midlands (WMD)
Worcestershire (WOR)
West Riding of Yorkshire (WRY)
West Yorkshire (WYK)
Yorkshire (YKS)",

//END
'' => ''
);
