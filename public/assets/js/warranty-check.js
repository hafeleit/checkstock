(function () {
    var lb = document.getElementById('lb');
    if (!lb) return;

    var groups = {};
    document.querySelectorAll('.wc-thumb').forEach(function (thumb) {
        var g = thumb.dataset.group;
        if (!groups[g]) groups[g] = [];
        groups[g].push(thumb.src);
    });

    var lbImg      = document.getElementById('lbImg');
    var lbPrev     = document.getElementById('lbPrev');
    var lbNext     = document.getElementById('lbNext');
    var lbClose    = document.getElementById('lbClose');
    var lbCounter  = document.getElementById('lbCounter');
    var lbDownload = document.getElementById('lbDownload');

    var currentGroup = [];
    var currentIdx   = 0;

    function render() {
        lbImg.src = currentGroup[currentIdx];
        lbCounter.textContent = currentGroup.length > 1
            ? (currentIdx + 1) + ' / ' + currentGroup.length
            : '';
        lbPrev.classList.toggle('lb-hidden', currentIdx === 0);
        lbNext.classList.toggle('lb-hidden', currentIdx === currentGroup.length - 1);
    }

    function openLb(group, idx) {
        currentGroup = groups[group] || [];
        currentIdx   = idx;
        render();
        lb.classList.add('is-open');
    }

    function closeLb() {
        lb.classList.remove('is-open');
        lbImg.src = '';
    }

    document.querySelectorAll('.wc-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            openLb(this.dataset.group, parseInt(this.dataset.index));
        });
    });

    lbPrev.addEventListener('click', function () {
        if (currentIdx > 0) { currentIdx--; render(); }
    });
    lbNext.addEventListener('click', function () {
        if (currentIdx < currentGroup.length - 1) { currentIdx++; render(); }
    });
    lbClose.addEventListener('click', closeLb);
    lb.addEventListener('click', function (e) {
        if (e.target === lb) closeLb();
    });
    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('is-open')) return;
        if (e.key === 'Escape')     { closeLb(); }
        if (e.key === 'ArrowLeft'  && currentIdx > 0)                        { currentIdx--; render(); }
        if (e.key === 'ArrowRight' && currentIdx < currentGroup.length - 1)  { currentIdx++; render(); }
    });

    lbDownload.addEventListener('click', function () {
        var src = currentGroup[currentIdx];
        if (!src) return;
        var a = document.createElement('a');
        a.href = src;
        a.download = src.split('/').pop();
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });
}());
