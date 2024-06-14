if [ ! -f ".env" ]; then
  echo 'Criando arquivo .env ...'
  cp .env.example .env
fi
echo 'Baixando dependencias e criando diretório vendor ...'
composer install
echo 'Gerando chave ...'
php artisan key:generate
echo 'Executando migrate ...'
php artisan migrate
echo 'Criando Link storage'
php artisan storage:link
echo 'Iniciando aplicação ...'
php artisan serve
