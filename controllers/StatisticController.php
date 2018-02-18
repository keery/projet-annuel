<?php
namespace Controllers;

use Module\View\View;

class StatisticController {
	
	public function indexAction()
	{
		View::render("statistic.view.php");
	}

}