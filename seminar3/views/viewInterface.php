<?php

interface iViewTemplate {
	public function pageHeadTag();
	public function pageContent();
	public function sidebarContent();
	public function output();
}