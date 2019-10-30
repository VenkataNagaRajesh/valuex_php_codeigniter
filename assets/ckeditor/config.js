/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function(config) {
    config.removePlugins = 'iframe';
    config.contentsLangDirection = 'ltr';
    config.allowedContent = true;
	config.extraPlugins = 'language';
	config.language_list = [ 'AB:Abkhazian', 'AA:Afar', 'AF:Afrikaans', 'SQ:Albanian', 'AM:Amharic', 'AR:Arabic', 'HY:Armenian', 'AS:Assamese', 'AY:Aymara', 'AZ:Azerbaijani', 'BA:Bashkir', 'EU:Basque', 'Bangla:Bengali,', 'DZ:Bhutani', 'BH:Bihari', 'BI:Bislama', 'BR:Breton', 'BG:Bulgarian', 'MY:Burmese', 'BE:Byelorussian', 'KM:Cambodian', 'CA:Catalan', 'ZH:Chinese', 'CO:Corsican', 'HR:Croatian', 'CS:Czech', 'DA:Danish', 'NL:Dutch', 'American:English,', 'EO:Esperanto', 'ET:Estonian', 'FO:Faeroese', 'FJ:Fiji', 'FI:Finnish', 'FR:French', 'FY:Frisian', '(Scots:Gaelic', 'GL:Galician', 'KA:Georgian', 'DE:German', 'EL:Greek', 'KL:Greenlandic', 'GN:Guarani', 'GU:Gujarati', 'HA:Hausa', 'IW:Hebrew', 'HI:Hindi', 'HU:Hungarian', 'IS:Icelandic', 'IN:Indonesian', 'IA:Interlingua', 'IE:Interlingue', 'IK:Inupiak', 'GA:Irish', 'IT:Italian', 'JA:Japanese', 'JW:Javanese', 'KN:Kannada', 'KS:Kashmiri', 'KK:Kazakh', 'RW:Kinyarwanda', 'KY:Kirghiz', 'RN:Kirundi', 'KO:Korean', 'KU:Kurdish', 'LO:Laothian', 'LA:Latin', 'Lettish:Latvian,', 'LN:Lingala', 'LT:Lithuanian', 'MK:Macedonian', 'MG:Malagasy', 'MS:Malay', 'ML:Malayalam', 'MT:Maltese', 'MI:Maori', 'MR:Marathi', 'MO:Moldavian', 'MN:Mongolian', 'NA:Nauru', 'NE:Nepali', 'NO:Norwegian', 'OC:Occitan', 'OR:Oriya', 'Afan:Oromo,', 'Pushto:Pashto,', 'FA:Persian', 'PL:Polish', 'PT:Portuguese', 'PA:Punjabi', 'QU:Quechua', 'RM:Rhaeto-Romance', 'RO:Romanian', 'RU:Russian', 'SM:Samoan', 'SG:Sangro', 'SA:Sanskrit', 'SR:Serbian', 'SH:Serbo-Croatian', 'ST:Sesotho', 'TN:Setswana', 'SN:Shona', 'SD:Sindhi', 'SI:Singhalese', 'SS:Siswati', 'SK:Slovak', 'SL:Slovenian', 'SO:Somali', 'ES:Spanish', 'SU:Sudanese', 'SW:Swahili', 'SV:Swedish', 'TL:Tagalog', 'TG:Tajik', 'TA:Tamil', 'TT:Tatar', 'TE:Tegulu', 'TH:Thai', 'BO:Tibetan', 'TI:Tigrinya', 'TO:Tonga', 'TS:Tsonga', 'TR:Turkish', 'TK:Turkmen', 'TW:Twi', 'UK:Ukrainian', 'UR:Urdu', 'UZ:Uzbek', 'VI:Vietnamese', 'VO:Volapuk', 'CY:Welsh', 'WO:Wolof', 'XH:Xhosa', 'JI:Yiddish', 'YO:Yoruba', 'ZU:Zulu'];
	config.defaultLanguage = 'en';	
    //config.fullPage = true;    
};