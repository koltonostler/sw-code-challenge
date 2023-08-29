setup:
	npm install
	@make build
	@make up

build:
	docker build -t code-challenge-frontend .
up:
	docker run -it -p 8080:8080 --rm --name frontend code-challenge-frontend

