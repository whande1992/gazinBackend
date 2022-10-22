<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


# `Desafio GazinTech Backend`
# **API Developer (Backend)**

Projeto realizado com intuito de avaliação tecnica, o propósito do teste é analisar boas práticas, lógica de programação, reaproveitamento de código e conhecimento geral das tecnologias escolhidas e utilizadas.


### **Tecnologias Utilizadas no projeto**
Docker | Laravel 9 | PHP 8.1 | Heroku

### Ferramentas para auxilio

[Postman](https://insomnia.rest/download) - Testes API

[Document API](https://documenter.getpostman.com/view/24012300/2s84DoTPia) - Documentação da API

[Beekeeper](https://www.beekeeperstudio.io/) - Database Manager


### **Instalação**

#### **1.** Clone do repositório

```
git clone https://github.com/whande1992/gazinBackend.git && cd gazinBackend/
```

## Docker

### Linux (Ubuntu 22.04)

Atualização do sistema operacional
```bash 
sudo apt update
```

Atualização de dependencias
```bash 
sudo apt install apt-transport-https curl gnupg-agent ca-certificates software-properties-common -y
```

Atualização do sistema operacional
```bash 
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
```

###Install Docker
```bash 
sudo apt update
```

Isso instala o Docker e todos os pacotes, bibliotecas e dependências adicionais exigidos pelo Docker e pacotes associados.

```bash 
sudo apt install docker-ce docker-ce-cli containerd.io -y
```

Depois que o comando for executado com êxito, considere adicionar o usuário conectado no momento ao grupo docker. Isso permite que você execute o docker sem invocar o sudo.

```bash 
sudo usermod -aG docker $USER
```
```bash 
newgrp docker
```

Confirme que o Docker esta instalado
```bash 
docker version
```

Se, por algum motivo, o Docker não estiver em execução, basta executar o seguinte comando:
```bash 
sudo systemctl start docker
```


Installing Docker Compose
```bash 
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
```

Em seguida, defina as permissões corretas para que o docker-composecomando seja executável:
```bash 
sudo chmod +x /usr/local/bin/docker-compose
```

Para verificar se a instalação foi bem-sucedida, você pode executar:
```bash 
docker-compose --version
```

Em seguida, defina as permissões corretas para que o docker-composecomando seja executável:
```bash 
sudo chmod +x /usr/local/bin/docker-compose
```


## Provisionando serviços
```
docker compose up -d --build
```
#### **2.** Instale as dependências do projeto
```     
docker exec -it app-backend composer install 
```

#### Configurando cache
```     
docker exec -it app-backend php artisan config:cache 
```

#### Migrations e seed
```     
docker exec -it app-backend php artisan migrate --seed
```

#### Testes
```     
docker exec -it app-backend php artisan test
```

http://127.0.0.1:8080/api/v1
    
[Document API](https://documenter.getpostman.com/view/24012300/2s84DoTPia) - Documentação da API
