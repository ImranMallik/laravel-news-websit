var CommonJS = {
  /*---------------- Number Validation --------------------*/
  NumberValidation: function () {
    $('.number-validate').on('keypress input paste', function (event) {
      var _this = $(this);
      var inputValue = _this.val();


      if (_this.hasClass('border-danger')) {
        _this.removeClass('border-danger');
      }

      // Handling keypress event (for direct typing)
      if (event.type === 'keypress') {
        var keycode = event.which;

        // Allow backspace, arrows, and numbers 0-9 + decimal point only once
        if (!(event.shiftKey == false &&
          (keycode == 46 && inputValue.indexOf('.') == -1) || // Decimal point only once
          keycode == 8 ||  // Backspace key
          keycode == 37 || // Left arrow key
          keycode == 39 || // Right arrow key
          (keycode >= 48 && keycode <= 57))) { // Numbers 0-9
          event.preventDefault(); // Prevent invalid input
        }
      }

      // Handling paste event
      if (event.type === 'paste') {
        setTimeout(function () {
          var pastedValue = _this.val();
          if (!/^\d*\.?\d*$/.test(pastedValue)) {
            _this.val('');  // Clear invalid input
            alert('Only numbers with a single decimal point are allowed.');
            _this.addClass('border-danger');
          }
        }, 0); // Use timeout to allow paste event to complete
      }

      // Handling input event (for programmatic changes)
      if (event.type === 'input') {
        if (!/^\d*\.?\d*$/.test(_this.val())) {
          _this.val('');  // Clear invalid input
          _this.addClass('border-danger');
        }
      }
    });
  },

  NumberValidationIntger: function () {
    $('.number-validate-int').on('keypress input paste', function (event) {
      var _this = $(this);
      var inputValue = _this.val();

      // Remove border-danger class if present
      if (_this.hasClass('border-danger')) {
        _this.removeClass('border-danger');
      }

      // Handling keypress event (for direct typing)
      if (event.type === 'keypress') {
        var keycode = event.which;

        if (!(event.shiftKey == false &&
          (keycode == 8 ||
            keycode == 37 ||
            keycode == 39 ||
            (keycode >= 48 && keycode <= 57)))) {
          event.preventDefault();
        }
      }

      // Handling paste event (prevents non-integer values from being pasted)
      if (event.type === 'paste') {
        setTimeout(function () {
          var pastedValue = _this.val();
          if (!/^\d+$/.test(pastedValue)) {
            _this.val('');
            alert('Only whole numbers (integers) are allowed.');
            _this.addClass('border-danger');
          }
        }, 0);
      }

      // Handling input event (for programmatic changes or autofill)
      if (event.type === 'input') {
        if (!/^\d*$/.test(inputValue)) {
          _this.val('');  // Clear invalid input
          _this.addClass('border-danger');
        }
      }
    });
  }
}
