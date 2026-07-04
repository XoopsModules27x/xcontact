document.addEventListener('DOMContentLoaded', function () {
    xcontactInitSignaturePads();
    xcontactInitImageChoiceToggle();
});

/**
 * Signature pads
 */
function xcontactInitSignaturePads() {
    var pads = document.querySelectorAll('.xcontact-sig-pad');

    if (!pads.length) {
        return;
    }

    pads.forEach(function (canvas) {
        var ctx = canvas.getContext('2d');
        var drawing = false;

        ctx.strokeStyle = '#222';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';

        function getPoint(e) {
            var rect = canvas.getBoundingClientRect();
            var src = e.touches ? e.touches[0] : e;

            return {
                x: (src.clientX - rect.left) * (canvas.width / rect.width),
                y: (src.clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDraw(e) {
            drawing = true;
            var pt = getPoint(e);
            ctx.beginPath();
            ctx.moveTo(pt.x, pt.y);
        }

        function moveDraw(e) {
            if (!drawing) {
                return;
            }
            var pt = getPoint(e);
            ctx.lineTo(pt.x, pt.y);
            ctx.stroke();
        }
        function endDraw() {
            if (drawing) {
                drawing = false;
                xcontactSyncSignature(canvas);
            }
        }

        // Mouse
        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', moveDraw);
        canvas.addEventListener('mouseup', endDraw);
        canvas.addEventListener('mouseleave', endDraw);

        // Touch
        canvas.addEventListener('touchstart', function (e) {
            e.preventDefault();
            startDraw(e);
        }, { passive: false });

        canvas.addEventListener('touchmove', function (e) {
            e.preventDefault();
            moveDraw(e);
        }, { passive: false });

        canvas.addEventListener('touchend', endDraw);
        canvas.addEventListener('touchcancel', endDraw);
    });
}

/**
 * Copy signature canvas data to hidden input
 */
function xcontactSyncSignature(canvas) {
    var id = canvas.id.replace('sig_', '');
    var input = document.getElementById('sig_data_' + id);

    if (input) {
        input.value = canvas.toDataURL();
    }
}

/**
 * Global clear function because template/button may call it via onclick
 */
window.xcfSigClear = function (fieldName) {
    var canvas = document.getElementById('sig_' + fieldName);

    if (!canvas) {
        return;
    }

    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);

    var input = document.getElementById('sig_data_' + fieldName);
    if (input) {
        input.value = '';
    }
};

/**
 * Toggle active class for image choice / option image containers
 */
function xcontactInitImageChoiceToggle() {
    document.querySelectorAll('.xcontact-oi-container').forEach(function (container) {
        var parent = container.parentElement;
        if (!parent) {
            return;
        }

        var input = parent.querySelector("input[type='checkbox'], input[type='radio']");
        if (!input) {
            return;
        }

        function syncState() {
            container.classList.toggle('aktiv', input.checked);
        }

        input.addEventListener('change', syncState);
        syncState();
    });
}