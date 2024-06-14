#!/bin/sh

echo "##########################################"
echo "PAINEL PARA INICIAR O PROJETO"
echo "########################################## \n"

echo "Selecione a opção abaixo: \n

[1]- Iniciar o projeto pela primeira vez
[2]- Executar Composer Install, Migrate
[3]- Iniciar o projeto para desenvolvimento \n

Inserir o codigo desejado:
"

read opcao

echo "Opcao selecionada: $opcao \n"

case $opcao in
        "1")
                echo 'Baixar dependencias e criando diretório vendor ... \n'
                composer install

                echo '\n'

                echo 'Executar migrate ... \n'
                php artisan migrate

                echo '\n'

                echo "Habilitar o compartilhando publico ... \n"
                php artisan storage:link

                echo '\n'

                echo "Limpar o cache ... \n"
                php artisan optimize:clear

                echo '\n'

                echo "Baixar as novas branches ... \n"
                git fetch --all

                echo '\n'

                echo "Iniciar o apache ... \n"
                apachectl start

                echo '\n'

                ;;
        "2")
                echo 'Baixar dependencias e criando diretório vendor ... \n'
                composer install

                echo '\n'

                echo 'Executar migrate ... \n'
                php artisan migrate

                echo '\n'

                echo "Limpar o cache ... \n"
                php artisan optimize:clear

                echo '\n'

                echo "Baixar as novas branches ... \n"
                git fetch --all

                echo '\n'

                echo "Iniciar o apache ... \n"
                apachectl start

                echo '\n'

                ;;
        "3")
                echo "Limpar o cache ... \n"
                php artisan optimize:clear

                echo '\n'

                echo "Baixar as novas branches ... \n"
                git fetch --all

                echo '\n'

                echo "Iniciar o apache ... \n"
                apachectl start

                echo '\n'

                ;;
        *)
                sh compose/php/iniciar_projeto.sh
                ;;
esac



echo "##########################################"
echo "SCRIPT FINALIZADO"
echo "########################################## \n"