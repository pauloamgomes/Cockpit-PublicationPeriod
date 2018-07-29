<field-publicationperiod>
    <div class="uk-panel uk-panel-box">
      <div>
        <i class="uk-icon-clock-o uk-margin-small-right"></i><span class="uk-margin-small-right">{ App.i18n.get('From:') }</span>
        <input ref="start" class="uk-width-1-4" value="{ this.value.start }" type="text" placeholder="Starting Date">
        <span class="uk-margin-small-right uk-margin-small-left">{ App.i18n.get('To:') }</span>
        <input ref="end" class="uk-width-1-4" value="{ this.value.end }" type="text" placeholder="Ending Date">
      </div>
      <span class="uk-text-small uk-text-muted">{ App.i18n.get('Set a starting and ending date when this content will be available.') }</span>
    </div>

    <script>
        var $this = this;

        this.value = {
          start: '',
          end: ''
        }

        opts.format = 'YYYY-MM-DD HH:mm';
        opts.weekstart = 0;

        if (opts.cls) {
            App.$(this.refs.publicationPeriod).addClass(opts.cls);
        }

        this.on('mount', function(){
            App.assets.require(['/assets/lib/uikit/js/components/datepicker.js', '/assets/lib/uikit/js/components/form-select.js'], function() {

                UIkit.datepicker(this.refs.start, opts).element.on('change', function() {
                    $this.value.start = $this.refs.start.value;
                    $this.$setValue($this.value);
                });

                UIkit.datepicker(this.refs.end, opts).element.on('change', function() {
                    $this.value.end = $this.refs.end.value;
                    $this.$setValue($this.value);
                });

            }.bind(this));

            this.update();
        });

        this.$updateValue = function(value, field) {
          this.value.start = value && value.start || '';
          this.value.end = value && value.end || '';
          this.update();
        }.bind(this);

    </script>

</field-publicationperiod>
