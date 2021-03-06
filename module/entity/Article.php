<?php
namespace Module\Entity;
use Module\Bdd\BaseSql;
use Module\Bdd\SqlManager;
use Module\Entity\Categorie;

class Article extends BaseSql {
	protected $id;
	protected $titre;
	protected $auteur;
	protected $description;
	protected $categorie;
	protected $date_creation;
	protected $date_update;
	protected $active;
	public $keyword;
	protected $images;

	public $mapping = [
		"id_categorie" => [
			"relation" => ONE_TO_MANY,
			"target" => "Module\Entity\Categorie",
			"property" => "categorie"
		],
		"id_article" => [
			"relation" => MANY_TO_ONE,
			"target" => "Module\Entity\Image",
			"property" => "images",
			"adding" => "addImage",
		]
	];

	public function __construct() {
		parent::__construct();
		$this->date_creation = date("Y-m-d G:h:i");
	}

	public function getTitre() {
		return $this->titre;
	}
	public function setTitre($titre) {
		$this->titre = $titre;
	}

	public function getKeyword() {
		return $this->keyword;
	}
	public function setKeyword($keyword) {
		$this->keyword = $keyword;
	}

	public function getAuteur() {
		return $this->auteur;
	}
	public function setAuteur($auteur) {
		$this->auteur = $auteur;
	}	

	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}

	public function getCategorie() {
		return $this->categorie;
	}
	public function setCategorie(Categorie $categorie) {
		$this->categorie = $categorie;
	}


	public function setDate_creation($date) {
		$this->date_creation = $date;
	}

	public function getDate_update() {
		return $this->date_update;
	}
	public function setDate_update($date) {
		$this->date_update = $date;
	}

	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		$this->active = $active;
	}

	public static function get_table_class() { return "cd_article"; }

    public function getDate_creation() {
        return $this->date_creation;
	}
	
	public function addImage($image) {
		$this->images[] = $image;
	}
	public function getImages() {
		return $this->images;
	}	
}