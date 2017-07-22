<?php
function bt_custom_icons() {
	$arr = array(
		'medical-book (custom)' => 'cs_' . 'e900',
		'24-hours-bed (custom)' => 'cs_' . 'e901',
		'24-hours-umbrella (custom)' => 'cs_' . 'e902',
		'24-hours-pills-cart (custom)' => 'cs_' . 'e903',
		'24-hours-building (custom)' => 'cs_' . 'e904',
		'24-hours-van (custom)' => 'cs_' . 'e905',
		'24-hours-phone (custom)' => 'cs_' . 'e906',
		'book-heart (custom)' => 'cs_' . 'e907',
		'alarm (custom)' => 'cs_' . 'e908',
		'ambulance (custom)' => 'cs_' . 'e909',
		'24-hours-ambulance (custom)' => 'cs_' . 'e90a',
		'apple-bottle (custom)' => 'cs_' . 'e90b',
		'apple-fork (custom)' => 'cs_' . 'e90c',
		'apple-shield (custom)' => 'cs_' . 'e90d',
		'apple-paper (custom)' => 'cs_' . 'e90e',
		'apple (custom)' => 'cs_' . 'e90f',
		'asterisk (custom)' => 'cs_' . 'e910',
		'radish-fork (custom)' => 'cs_' . 'e911',
		'ball (custom)' => 'cs_' . 'e912',
		'band (custom)' => 'cs_' . 'e913',
		'band-cross (custom)' => 'cs_' . 'e914',
		'bar-shield (custom)' => 'cs_' . 'e915',
		'beaker (custom)' => 'cs_' . 'e916',
		'bed (custom)' => 'cs_' . 'e917',
		'bicycle (custom)' => 'cs_' . 'e918',
		'blood-search (custom)' => 'cs_' . 'e919',
		'blood-group-zero (custom)' => 'cs_' . 'e91a',
		'blood-group-b (custom)' => 'cs_' . 'e91b',
		'blood-group-ab (custom)' => 'cs_' . 'e91c',
		'blood-group-a (custom)' => 'cs_' . 'e91d',
		'caduceus (custom)' => 'cs_' . 'e91e',
		'calendar-hospital (custom)' => 'cs_' . 'e91f',
		'call-ambulance (custom)' => 'cs_' . 'e920',
		'cardiac (custom)' => 'cs_' . 'e921',
		'catholic (custom)' => 'cs_' . 'e922',
		'cell (custom)' => 'cs_' . 'e923',
		'circle-male (custom)' => 'cs_' . 'e924',
		'clinic-folder (custom)' => 'cs_' . 'e925',
		'clock-apple (custom)' => 'cs_' . 'e926',
		'conversations (custom)' => 'cs_' . 'e927',
		'cross (custom)' => 'cs_' . 'e928',
		'curved (custom)' => 'cs_' . 'e929',
		'dentist-calendar (custom)' => 'cs_' . 'e92a',
		'dentist-books (custom)' => 'cs_' . 'e92b',
		'dentist-tool (custom)' => 'cs_' . 'e92c',
		'dentist-tools (custom)' => 'cs_' . 'e92d',
		'dentist-24-hours (custom)' => 'cs_' . 'e92e',
		'dentist-chat (custom)' => 'cs_' . 'e92f',
		'diet (custom)' => 'cs_' . 'e930',
		'disease (custom)' => 'cs_' . 'e931',
		'dna (custom)' => 'cs_' . 'e932',
		'drop-shield (custom)' => 'cs_' . 'e933',
		'drop (custom)' => 'cs_' . 'e934',
		'dropper (custom)' => 'cs_' . 'e935',
		'drug (custom)' => 'cs_' . 'e936',
		'drug-skull (custom)' => 'cs_' . 'e937',
		'drugs-bottle (custom)' => 'cs_' . 'e938',
		'drugs-cart (custom)' => 'cs_' . 'e939',
		'drugs-discount (custom)' => 'cs_' . 'e93a',
		'dumbbell (custom)' => 'cs_' . 'e93b',
		'ear (custom)' => 'cs_' . 'e93c',
		'energy (custom)' => 'cs_' . 'e93d',
		'eye (custom)' => 'cs_' . 'e93e',
		'glasses (custom)' => 'cs_' . 'e93f',
		'female (custom)' => 'cs_' . 'e940',
		'first-aid (custom)' => 'cs_' . 'e941',
		'first-aid-phone (custom)' => 'cs_' . 'e942',
		'flag-cross (custom)' => 'cs_' . 'e943',
		'flask (custom)' => 'cs_' . 'e944',
		'fork (custom)' => 'cs_' . 'e945',
		'frequency (custom)' => 'cs_' . 'e946',
		'glass-snake (custom)' => 'cs_' . 'e947',
		'hand-heart (custom)' => 'cs_' . 'e948',
		'handicapped (custom)' => 'cs_' . 'e949',
		'health-apple-book (custom)' => 'cs_' . 'e94a',
		'health-hospital-discount (custom)' => 'cs_' . 'e94b',
		'healthy-apple (custom)' => 'cs_' . 'e94c',
		'healthy-dentist (custom)' => 'cs_' . 'e94d',
		'heart-cross (custom)' => 'cs_' . 'e94e',
		'heart-cross2 (custom)' => 'cs_' . 'e94f',
		'heart-shield (custom)' => 'cs_' . 'e950',
		'heart-calendar (custom)' => 'cs_' . 'e951',
		'heart-beats (custom)' => 'cs_' . 'e952',
		'heartbeat (custom)' => 'cs_' . 'e953',
		'heartbeats (custom)' => 'cs_' . 'e954',
		'helicopter-24-hours (custom)' => 'cs_' . 'e955',
		'herbal-tea (custom)' => 'cs_' . 'e956',
		'hospital-phone (custom)' => 'cs_' . 'e957',
		'hospital-wheels (custom)' => 'cs_' . 'e958',
		'hospital-map-pin (custom)' => 'cs_' . 'e959',
		'hospital-circle-mark (custom)' => 'cs_' . 'e95a',
		'hospital-building (custom)' => 'cs_' . 'e95b',
		'human-sleeping (custom)' => 'cs_' . 'e95c',
		'human-kidney (custom)' => 'cs_' . 'e95d',
		'immunity-pills (custom)' => 'cs_' . 'e95e',
		'increasing-heart-chart (custom)' => 'cs_' . 'e95f',
		'inhaler (custom)' => 'cs_' . 'e960',
		'intravenous (custom)' => 'cs_' . 'e961',
		'injection (custom)' => 'cs_' . 'e962',
		'knife (custom)' => 'cs_' . 'e963',
		'leaf (custom)' => 'cs_' . 'e964',
		'lifeline (custom)' => 'cs_' . 'e965',
		'lifeline-heart (custom)' => 'cs_' . 'e966',
		'liquid-bottle (custom)' => 'cs_' . 'e967',
		'liver (custom)' => 'cs_' . 'e968',
		'male-female (custom)' => 'cs_' . 'e969',
		'male (custom)' => 'cs_' . 'e96a',
		'masculine (custom)' => 'cs_' . 'e96b',
		'medical-calendar-eye (custom)' => 'cs_' . 'e96c',
		'medical-croch (custom)' => 'cs_' . 'e96d',
		'medical-bubble (custom)' => 'cs_' . 'e96e',
		'medical-chopper-phone (custom)' => 'cs_' . 'e96f',
		'medical-chopper (custom)' => 'cs_' . 'e970',
		'medical-shield-24-hours (custom)' => 'cs_' . 'e971',
		'medical-bag (custom)' => 'cs_' . 'e972',
		'medical-beds (custom)' => 'cs_' . 'e973',
		'medical-chart-increasing (custom)' => 'cs_' . 'e974',
		'medical-van (custom)' => 'cs_' . 'e975',
		'medical-chemicals (custom)' => 'cs_' . 'e976',
		'medical-microscope (custom)' => 'cs_' . 'e977',
		'medical-note (custom)' => 'cs_' . 'e978',
		'medical-cross-24-hours (custom)' => 'cs_' . 'e979',
		'medical-chart-lowering (custom)' => 'cs_' . 'e97a',
		'medical-heart-zoom (custom)' => 'cs_' . 'e97b',
		'medical-chat-dna (custom)' => 'cs_' . 'e97c',
		'medical-note-pencil (custom)' => 'cs_' . 'e97d',
		'medical-blood-pressure (custom)' => 'cs_' . 'e97e',
		'medicine-something (custom)' => 'cs_' . 'e97f',
		'medicine-pills (custom)' => 'cs_' . 'e980',
		'medicine-tent (custom)' => 'cs_' . 'e981',
		'medicine-photo (custom)' => 'cs_' . 'e982',
		'medicine-pills-bottle (custom)' => 'cs_' . 'e983',
		'medicine-pills-on-discount (custom)' => 'cs_' . 'e984',
		'medicine-potion-bottle (custom)' => 'cs_' . 'e985',
		'medicine-potion-covered (custom)' => 'cs_' . 'e986',
		'medicine-drugs-glass (custom)' => 'cs_' . 'e987',
		'medicines-calendar (custom)' => 'cs_' . 'e988',
		'medicines-clock (custom)' => 'cs_' . 'e989',
		'medicines-bottle-glass (custom)' => 'cs_' . 'e98a',
		'mortar-cart (custom)' => 'cs_' . 'e98b',
		'mortar (custom)' => 'cs_' . 'e98c',
		'music (custom)' => 'cs_' . 'e98d',
		'natural-mortal (custom)' => 'cs_' . 'e98e',
		'no-smoking (custom)' => 'cs_' . 'e98f',
		'nurse (custom)' => 'cs_' . 'e990',
		'oxygen (custom)' => 'cs_' . 'e991',
		'pharmaceutical (custom)' => 'cs_' . 'e992',
		'pharmaceutical-cart (custom)' => 'cs_' . 'e993',
		'pharmacy-cart-phone (custom)' => 'cs_' . 'e994',
		'pharmacy-cart (custom)' => 'cs_' . 'e995',
		'pharmacy-cart-mortar (custom)' => 'cs_' . 'e996',
		'plaster (custom)' => 'cs_' . 'e997',
		'plus-eye (custom)' => 'cs_' . 'e998',
		'plus-kidneys (custom)' => 'cs_' . 'e999',
		'pressuring (custom)' => 'cs_' . 'e99a',
		'radish (custom)' => 'cs_' . 'e99b',
		'red-cross (custom)' => 'cs_' . 'e99c',
		'right-chart-heart (custom)' => 'cs_' . 'e99d',
		'scissor (custom)' => 'cs_' . 'e99e',
		'searching-folder (custom)' => 'cs_' . 'e99f',
		'shield (custom)' => 'cs_' . 'e9a0',
		'skull-in-bottle (custom)' => 'cs_' . 'e9a1',
		'smile (custom)' => 'cs_' . 'e9a2',
		'sparkling (custom)' => 'cs_' . 'e9a3',
		'speech-hearbeat (custom)' => 'cs_' . 'e9a4',
		'sperms (custom)' => 'cs_' . 'e9a5',
		'spheres (custom)' => 'cs_' . 'e9a6',
		'spoon-fork-plate (custom)' => 'cs_' . 'e9a7',
		'stethoscope (custom)' => 'cs_' . 'e9a8',
		'syringe (custom)' => 'cs_' . 'e9a9',
		'syringe-needle (custom)' => 'cs_' . 'e9aa',
		'tablets (custom)' => 'cs_' . 'e9ab',
		'tape (custom)' => 'cs_' . 'e9ac',
		'telephone (custom)' => 'cs_' . 'e9ad',
		'test (custom)' => 'cs_' . 'e9ae',
		'testing (custom)' => 'cs_' . 'e9af',
		'test-small (custom)' => 'cs_' . 'e9b0',
		'testing-drop (custom)' => 'cs_' . 'e9b1',
		'thermometer (custom)' => 'cs_' . 'e9b2',
		'three-nuclear (custom)' => 'cs_' . 'e9b3',
		'three-disease (custom)' => 'cs_' . 'e9b4',
		'time-for-pills (custom)' => 'cs_' . 'e9b5',
		'time-for-biking (custom)' => 'cs_' . 'e9b6',
		'timer (custom)' => 'cs_' . 'e9b7',
		'tooth (custom)' => 'cs_' . 'e9b8',
		'tooth-cross (custom)' => 'cs_' . 'e9b9',
		'tooth-tool (custom)' => 'cs_' . 'e9ba',
		'tooth-brush (custom)' => 'cs_' . 'e9bb',
		'tooth-only (custom)' => 'cs_' . 'e9bc',
		'tooth-bottle (custom)' => 'cs_' . 'e9bd',
		'tooth-paste (custom)' => 'cs_' . 'e9be',
		'umbrella (custom)' => 'cs_' . 'e9bf',
		'honeycomb (custom)' => 'cs_' . 'e9c0',
		'vegetarian (custom)' => 'cs_' . 'e9c1',
		'wall-clock (custom)' => 'cs_' . 'e9c2',
		'water-apple (custom)' => 'cs_' . 'e9c3',
		'wheelchair (custom)' => 'cs_' . 'e9c4',
		'wineglass-snake-phone (custom)' => 'cs_' . 'e9c5',
		'zzz (custom)' => 'cs_' . 'e9c6',
		'animal (custom)' => 'cs_' . 'e9c7',
		'baby (custom)' => 'cs_' . 'e9c8',
		'computer-screen (custom)' => 'cs_' . 'e9c9',
		'disabled (custom)' => 'cs_' . 'e9ca',
		'doctor (custom)' => 'cs_' . 'e9cb',
		'stethoscope2 (custom)' => 'cs_' . 'e9cc',
		'document-cross (custom)' => 'cs_' . 'e9cd',
		'document (custom)' => 'cs_' . 'e9ce',
		'eyes (custom)' => 'cs_' . 'e9cf',
		'file (custom)' => 'cs_' . 'e9d0',
		'gene (custom)' => 'cs_' . 'e9d1',
		'health-care (custom)' => 'cs_' . 'e9d2',
		'health-care-plaster (custom)' => 'cs_' . 'e9d3',
		'health-care-briefcase (custom)' => 'cs_' . 'e9d4',
		'health-care-epruvete (custom)' => 'cs_' . 'e9d5',
		'health-care-paper (custom)' => 'cs_' . 'e9d6',
		'health-clinic (custom)' => 'cs_' . 'e9d7',
		'health-clinic-sign (custom)' => 'cs_' . 'e9d8',
		'healthy-care (custom)' => 'cs_' . 'e9d9',
		'healthy-food (custom)' => 'cs_' . 'e9da',
		'heart (custom)' => 'cs_' . 'e9db',
		'heart-pumping (custom)' => 'cs_' . 'e9dc',
		'hospital (custom)' => 'cs_' . 'e9dd',
		'hospital-doctor (custom)' => 'cs_' . 'e9de',
		'hospital-pills-bottle (custom)' => 'cs_' . 'e9df',
		'hospital-nurse (custom)' => 'cs_' . 'e9e0',
		'hospital-bed (custom)' => 'cs_' . 'e9e1',
		'hospital-sign (custom)' => 'cs_' . 'e9e2',
		'hospital-syringe (custom)' => 'cs_' . 'e9e3',
		'hospital-skeleton (custom)' => 'cs_' . 'e9e4',
		'hospital-syringe-with-needle (custom)' => 'cs_' . 'e9e5',
		'hospitals-desk (custom)' => 'cs_' . 'e9e6',
		'laboratory (custom)' => 'cs_' . 'e9e7',
		'list (custom)' => 'cs_' . 'e9e8',
		'medical-flash (custom)' => 'cs_' . 'e9e9',
		'medical-hands (custom)' => 'cs_' . 'e9ea',
		'medical-epruvete (custom)' => 'cs_' . 'e9eb',
		'medical-film (custom)' => 'cs_' . 'e9ec',
		'medical-laboratory (custom)' => 'cs_' . 'e9ed',
		'medicine-folder (custom)' => 'cs_' . 'e9ee',
		'medicine-pills2 (custom)' => 'cs_' . 'e9ef',
		'organs-lungs (custom)' => 'cs_' . 'e9f0',
		'person (custom)' => 'cs_' . 'e9f1',
		'pharmacy (custom)' => 'cs_' . 'e9f2',
		'pregnant (custom)' => 'cs_' . 'e9f3',
		'smartphone (custom)' => 'cs_' . 'e9f4',
		'stick-man (custom)' => 'cs_' . 'e9f5',
		'tooth2 (custom)' => 'cs_' . 'e9f6',
		'transport-helicopter (custom)' => 'cs_' . 'e9f7',
		'transport-van (custom)' => 'cs_' . 'e9f8',
		'plus-more (custom)' => 'cs_' . 'e9f9'

		);
	
	ksort( $arr );

	return $arr;
}