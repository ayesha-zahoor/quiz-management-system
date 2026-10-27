window.Perm = {
    ready: null,

    load() {
        const token = localStorage.getItem('api_token');
        if (!token) return $.Deferred().reject().promise();   // not logged in: still returns something .always() can use

        return $.ajax({
            url: '/api/me/permissions',
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token, Accept: 'application/json' }
        }).done(function (r) {
            localStorage.setItem('is_system_admin', r.is_system_admin ? '1' : '0');
            localStorage.setItem('permissions', JSON.stringify(r.permissions || []));
        });
    },

    can(name) {
        if (localStorage.getItem('is_system_admin') === '1') return true;
        try { return JSON.parse(localStorage.getItem('permissions') || '[]').includes(name); }
        catch (e) { return false; }
    },

    apply(root) {
        $(root || document).find('[data-permission]').each(function () {
            const any = String($(this).data('permission')).split(',').map(s => s.trim());
            if (!any.some(Perm.can)) $(this).remove();
        });
    }
};

Perm.ready = Perm.load();                                      // starts the request right away
$(function () { Perm.ready.always(() => Perm.apply()); });     // hide labeled items when it finishes