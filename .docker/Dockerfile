FROM gcr.io/mercur-2018/base-container-cli-xdebug:0.1.0

RUN apk add --update supervisor && rm  -rf /tmp/* /var/cache/apk/* \
    && mkdir -p /var/log/supervisor \
    && mkdir -p /etc/supervisor/conf.d

ADD supervisor/* /etc/supervisor/conf.d/
ADD supervisord.conf /etc/supervisor/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
