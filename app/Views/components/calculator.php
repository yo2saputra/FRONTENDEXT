<?php
$targetInput = $targetInput ?? null;
$btnLabel    = $btnLabel    ?? 'Kalkulator';
$btnClass    = $btnClass    ?? 'btn-success';
$instanceId  = 'calc_' . uniqid();
?>

<?= view('components/calculator', [
                                    'targetInput' => '#no_kwitansi',
                                    'btnLabel'    => 'Test Kalkulator',
                                    'btnClass'    => 'btn-secondary',
                                ]) ?>


<button type="button"
        class="btn btn-sm <?= esc($btnClass) ?> btn-open-calculator"
        data-instance="<?= $instanceId ?>">
    <i class="fas fa-calculator mr-1"></i> <?= esc($btnLabel) ?>
</button>

<div class="modal fade"
     id="modal-<?= $instanceId ?>"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:280px;">
        <div class="modal-content">

            <div class="modal-header" style="padding:10px 16px;">
                <h6 class="modal-title" style="font-weight:600;">
                    <i class="fas fa-calculator mr-1 text-info"></i> Kalkulator
                </h6>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-2">
                <div class="mb-2" style="background:#f8f9fa; border:1px solid #dee2e6;
                     border-radius:4px; padding:8px 12px; text-align:right;">
                    <div class="calc-expression-<?= $instanceId ?>"
                         style="color:#999; font-size:11px; min-height:14px;
                                font-family:'Courier New',monospace; word-break:break-all;">
                        &nbsp;
                    </div>
                    <div class="calc-display-<?= $instanceId ?>"
                         style="font-size:26px; font-weight:400; font-family:'Courier New',monospace;
                                word-break:break-all; color:#333; min-height:34px; line-height:1.2;">
                        0
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:5px;">

                    <button class="calc-btn btn btn-sm btn-secondary"
                            data-instance="<?= $instanceId ?>" data-action="clear">AC</button>
                    <button class="calc-btn btn btn-sm btn-secondary"
                            data-instance="<?= $instanceId ?>" data-action="sign">+/-</button>
                    <button class="calc-btn btn btn-sm btn-secondary"
                            data-instance="<?= $instanceId ?>" data-action="percent">%</button>
                    <button class="calc-btn btn btn-sm btn-warning"
                            data-instance="<?= $instanceId ?>" data-action="operator" data-value="÷">÷</button>

                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="7">7</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="8">8</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="9">9</button>
                    <button class="calc-btn btn btn-sm btn-warning"
                            data-instance="<?= $instanceId ?>" data-action="operator" data-value="×">×</button>

                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="4">4</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="5">5</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="6">6</button>
                    <button class="calc-btn btn btn-sm btn-warning"
                            data-instance="<?= $instanceId ?>" data-action="operator" data-value="-">−</button>

                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="1">1</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="2">2</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value="3">3</button>
                    <button class="calc-btn btn btn-sm btn-warning"
                            data-instance="<?= $instanceId ?>" data-action="operator" data-value="+">+</button>

                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>"
                            data-action="digit" data-value="0"
                            style="grid-column:span 2;">0</button>
                    <button class="calc-btn btn btn-sm btn-default"
                            data-instance="<?= $instanceId ?>" data-action="digit" data-value=".">.</button>
                    <button class="calc-btn btn btn-sm btn-success"
                            data-instance="<?= $instanceId ?>" data-action="equals">=</button>

                </div>

                <?php if ($targetInput): ?>
                <div class="mt-2">
                    <button class="btn btn-sm btn-info btn-block calc-use-result"
                            data-instance="<?= $instanceId ?>"
                            data-target="<?= esc($targetInput) ?>">
                        <i class="fas fa-check mr-1"></i> Gunakan Hasil
                    </button>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
(function () {

    var instanceId = '<?= $instanceId ?>';
    var modalSel   = '#modal-' + instanceId;

    function waitForJQuery(callback) {
        if (window.jQuery) {
            callback();
        } else {
            setTimeout(function () { waitForJQuery(callback); }, 50);
        }
    }

    waitForJQuery(function () {

        var state = {
            display          : '0',
            expression       : '',
            firstOperand     : null,
            operator         : null,
            waitingForSecond : false,
            justCalculated   : false
        };

        var $display    = $('.calc-display-'    + instanceId);
        var $expression = $('.calc-expression-' + instanceId);

        function render() {
            $display.text(state.display);
            $expression.text(state.expression || '\u00a0');
        }

        function fmt(num) {
            var n = parseFloat(num);
            return isNaN(n) ? '0' : parseFloat(n.toPrecision(10)).toString();
        }

        function doCalc(a, b, op) {
            switch (op) {
                case '+': return a + b;
                case '-': return a - b;
                case '×': return a * b;
                case '÷': return b !== 0 ? a / b : 'Error';
                default : return b;
            }
        }

        function inputDigit(d) {
            if (state.waitingForSecond) {
                state.display          = d === '.' ? '0.' : d;
                state.waitingForSecond = false;
            } else {
                if (d === '.' && state.display.indexOf('.') !== -1) return;
                if (state.display === '0' && d !== '.') {
                    state.display = d;
                } else {
                    if (state.display.replace('-', '').replace('.', '').length >= 12) return;
                    state.display += d;
                }
            }
            state.justCalculated = false;
            render();
        }

        function handleOperator(op) {
            var cur = parseFloat(state.display);

            if (state.operator && state.waitingForSecond) {
                state.operator   = op;
                state.expression = fmt(state.firstOperand) + ' ' + op;
                render();
                return;
            }

            if (state.firstOperand === null || state.justCalculated) {
                state.firstOperand = cur;
            } else if (state.operator) {
                var res            = doCalc(state.firstOperand, cur, state.operator);
                state.display      = fmt(res);
                state.firstOperand = res;
            }

            state.operator         = op;
            state.waitingForSecond = true;
            state.justCalculated   = false;
            state.expression       = fmt(state.firstOperand) + ' ' + op;
            render();
        }

        function handleEquals() {
            if (!state.operator) return;
            var cur          = parseFloat(state.display);
            var res          = doCalc(state.firstOperand, cur, state.operator);
            state.expression = fmt(state.firstOperand) + ' ' + state.operator + ' ' + fmt(cur) + ' =';
            state.display    = res === 'Error' ? 'Error' : fmt(res);
            state.firstOperand     = null;
            state.operator         = null;
            state.waitingForSecond = false;
            state.justCalculated   = true;
            render();
        }

        function handleClear() {
            state.display          = '0';
            state.expression       = '';
            state.firstOperand     = null;
            state.operator         = null;
            state.waitingForSecond = false;
            state.justCalculated   = false;
            render();
        }

        function handleSign() {
            if (state.display === '0' || state.display === 'Error') return;
            state.display = state.display.charAt(0) === '-'
                ? state.display.slice(1)
                : '-' + state.display;
            render();
        }

        function handlePercent() {
            state.display = fmt(parseFloat(state.display) / 100);
            render();
        }

        $(document).on('click', '.calc-btn[data-instance="' + instanceId + '"]', function () {
            var action = $(this).data('action');
            var value  = String($(this).data('value') || '');
            switch (action) {
                case 'digit'   : inputDigit(value);     break;
                case 'operator': handleOperator(value); break;
                case 'equals'  : handleEquals();        break;
                case 'clear'   : handleClear();         break;
                case 'sign'    : handleSign();          break;
                case 'percent' : handlePercent();       break;
            }
        });

        $(document).on('keydown.calc-' + instanceId, function (e) {
            if (!$(modalSel).hasClass('show')) return;
            var k = e.key;
            if      (k >= '0' && k <= '9')            inputDigit(k);
            else if (k === '.')                        inputDigit('.');
            else if (k === '+')                        handleOperator('+');
            else if (k === '-')                        handleOperator('-');
            else if (k === '*')                        handleOperator('×');
            else if (k === '/') { e.preventDefault();  handleOperator('÷'); }
            else if (k === 'Enter' || k === '=')       handleEquals();
            else if (k === 'Escape')                   handleClear();
            else if (k === 'Backspace') {
                state.display = state.display.length > 1
                    ? state.display.slice(0, -1) : '0';
                render();
            }
        });

        $(document).on('show.bs.modal', modalSel, function () {
            handleClear();
        });

        $(document).on('click', '.btn-open-calculator[data-instance="' + instanceId + '"]', function () {
            $(modalSel).modal('show');
        });

        $(document).on('click', '.calc-use-result[data-instance="' + instanceId + '"]', function () {
            if (state.display === 'Error') return;
            var target = $(this).data('target');
            $(target).val(state.display).trigger('change');
            $(modalSel).modal('hide');
        });

    });

}());
</script>

