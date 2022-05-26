# FROM php:7.4.7-fpm
# RUN docker-php-ext-install pdo_mysql


FROM golang:1.15 AS builder
RUN go get -d -v github.com/mailhog/mhsendmail \
    && cd /go/src/github.com/mailhog/mhsendmail/ \
    && GOOS=linux GOARCH=arm64 go build -o mhsendmail .

FROM php:7.4.7-fpm
RUN docker-php-ext-install pdo_mysql

COPY --from=builder /go/src/github.com/mailhog/mhsendmail/mhsendmail /usr/local/bin/
RUN chmod +x /usr/local/bin/mhsendmail \
    && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/sendmail.ini


# RUN curl -sSLO https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 \
#     && chmod +x mhsendmail_linux_amd64 \
#     && mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail \
#     && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/mailhog.ini
# COPY ./php/php.ini /usr/local/etc/php/

# # web/Dockerfile
# # FROM php:7.4-apache

# # # wgetをインストールするよう修正
# # RUN apt-get update && apt-get install -y wget

# # # ホスト環境で作ったmailhog.iniをコンテナにコピー
# # # COPY ./php.ini /usr/local/etc/php/conf.d/mailhog.ini
# # COPY php.ini /usr/local/etc/php/


# # # mhsendmailコマンドのインストール。CURLでダウンロードしてインストールします。
# # RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
# #     && chmod +x mhsendmail \
# #     && mv mhsendmail /usr/local/bin/mhsendmail

# # web/Dockerfile
# # FROM php:7.4-apache

# # wgetをインストールするよう修正
# RUN apt-get update && apt-get install -y wget


# # mhsendmailコマンドのインストール。CURLでダウンロードしてインストールします。
# RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
#     && chmod +x mhsendmail \
#     && mv mhsendmail /usr/local/bin/mhsendmail

# # ホスト環境で作ったmailhog.iniをコンテナにコピー
# COPY mailhog.ini /usr/local/etc/php/conf.d/mailhog.ini