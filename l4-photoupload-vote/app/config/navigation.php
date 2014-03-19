<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
			'label' => 'Browse',
			'route' => 'home',
			'active' => array('/','popular','comments')
		),
		array(
			'label' => 'Create New',
			'route' => 'image.create',
			'active' => array('user/tricks/new'),
			// 'logged_in' => true
		),
	),

	'browse' => array(
		array(
			'label' => 'Most recent',
			'route' => 'home',
			'active' => array('/')
		),
		array(
			'label' => 'Most popular',
			'route' => 'browse.popular',
			'active' => array('popular')
		),
		array(
			'label' => 'Most commented',
			'route' => 'browse.comments',
			'active' => array('comments')
		),
	),

);
