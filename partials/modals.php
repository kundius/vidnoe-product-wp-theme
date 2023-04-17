<div class="hystmodal hystmodal--small" id="feedback" aria-hidden="true">
  <div class="hystmodal__wrap">
    <div class="hystmodal__window" role="dialog" aria-modal="true">
      <button data-hystclose class="hystmodal__close"></button>

      <form action="/wp-json/contact-form-7/v1/contact-forms/234/feedback" method="post" class="modal-form js-form">
        <div class="modal-form__title">
          Отправить заявку
        </div>

        <div class="modal-form__field">
          <input type="text" name="your-name" class="ui-input" placeholder="ФИО*" />
        </div>

        <div class="modal-form__field">
          <span class="wpcf7-form-control-wrap your-phone">
            <input type="tel" name="your-phone" value="" class="ui-input" placeholder="Телефон*">
          </span>
        </div>

        <div class="modal-form__field">
          <input type="email" name="your-email" class="ui-input" placeholder="E-mail*" />
        </div>

        <div class="modal-form__field">
          <textarea rows="4" name="your-message" class="ui-textarea" placeholder="Введите сообщение здесь"></textarea>
        </div>

        <div class="modal-form__rules">
          <span class="wpcf7-form-acceptance-wrap">
            <label class="ui-rules">
              <input type="checkbox" name="rules" value="1" class="form-checkbox">
              <span></span>
              Прочитал(-а) <a href="<?php the_permalink(289)?>" target="_blank">Пользовательское соглашение</a> и&nbsp;соглашаюсь с&nbsp;<a href="<?php the_permalink(3) ?>" target="_blank">Политикой конфиденциальности</a>
            </label>
          </span>
        </div>

        <div class="modal-form__submit">
          <button type="submit" class="ui-button-submit ui-button-submit_with-arrow ui-button-submit_upper">
            <span class="ui-loader-square modal-form__loader"></span>
            Отправить
          </button>
        </div>

        <div class="modal-form__success">
          <div class="modal-form-result modal-form-result_success">
            <div class="modal-form-result__head">
              <div class="modal-form-result__head-icon"></div>
              <div class="modal-form-result__head-title">
                Ваше сообщение
                успешно отправлено
              </div>
            </div>
            <div class="modal-form-result__body">
              <div class="modal-form-result__body-text">
                В ближайшее время<br />
                мы свяжемся с вами.
              </div>
              <div class="modal-form-result__body-close wpcf7-form-status-reset">
                Закрыть окно
              </div>
            </div>
          </div>
        </div>

        <div class="modal-form__failed">
          <div class="modal-form-result modal-form-result_failed">
            <div class="modal-form-result__head">
              <div class="modal-form-result__head-icon"></div>
              <div class="modal-form-result__head-title">
                Возникла ошибка
              </div>
            </div>
            <div class="modal-form-result__body">
              <div class="modal-form-result__body-text">
                Не удалось<br />
                отправить сообщение
              </div>
              <div class="modal-form-result__body-close wpcf7-form-status-reset">
                Закрыть окно
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
