FROM postgres:12

RUN echo "tzdata tzdata/Areas select America" > /tmp/preseed.txt; \
    echo "tzdata tzdata/Zones/America select Sao_Paulo" >> /tmp/preseed.txt; \
    debconf-set-selections /tmp/preseed.txt \
    && rm /etc/timezone \
    && rm /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata

RUN localedef -i pt_BR -c -f UTF-8 -A /usr/share/locale/locale.alias pt_BR.UTF-8

ENV LANG pt_BR.UTF-8

COPY ./compose/postgres/postgresql.conf /etc/postgres/postgresql.conf
COPY ./compose/postgres/create-multiple-databases.sh /docker-entrypoint-initdb.d/create-multiple-databases.sh

EXPOSE 5432