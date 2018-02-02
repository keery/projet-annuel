docker-bash:
	@docker exec -ti project bash

docker-up:
	cd docker && docker-compose up;
	node-sass /home/alex/labs/drawer/css/style.scss ./css/dist/style.css -w --output-style compressed --error-bell
