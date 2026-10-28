/*
 * Permission helper (public/js/permissions.js). Load it after jQuery.
 *
 *   Perm.can('create_classes')               true / false
 *   Perm.can('edit_classes,delete_classes')  true if ANY of them is allowed
 *   Perm.gate('view_classes', allowedFn, deniedFn)
 *                                            run a page only when it is allowed
 *   Perm.apply(root)                         remove [data-permission] elements the user may not use
 *
 * In HTML:  <button data-permission="create_classes">Add Class</button>
 *           <a data-permission="view_students,view_teachers">...</a>   (any of)
 */
window.Perm = {
    ready: null,

    load() {
        const token = localStorage.getItem('api_token');

        // Not logged in: return something .always() can still use
        if (!token) return $.Deferred().reject().promise();

        return $.ajax({
            url: '/api/me/permissions',
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token, Accept: 'application/json' }
        })
            .done(function (r) {
                localStorage.setItem('is_system_admin', r.is_system_admin ? '1' : '0');
                localStorage.setItem('permissions', JSON.stringify(r.permissions || []));
            })
            .fail(function (xhr) {
                // Session ended: forget the old permissions so nothing stays visible
                if (xhr.status === 401) {
                    localStorage.removeItem('is_system_admin');
                    localStorage.removeItem('permissions');
                }
            });
    },

    can(name) {
        if (localStorage.getItem('is_system_admin') === '1') return true;

        let list;
        try { list = JSON.parse(localStorage.getItem('permissions') || '[]'); }
        catch (e) { return false; }

        return String(name).split(',').some(n => list.includes(n.trim()));
    },

    gate(permission, allowed, denied) {
        this.ready.always(() => {
            if (this.can(permission)) allowed();
            else if (denied) denied();
        });
    },

    apply(root) {
        $(root || document).find('[data-permission]').each(function () {
            if (!Perm.can($(this).attr('data-permission'))) $(this).remove();
        });
    }
};

Perm.ready = Perm.load();   // starts the request right away

$(function () {
    Perm.ready.always(function () {
        Perm.apply();

        // Elements added later (table rows, modals) are checked too
        new MutationObserver(function () { Perm.apply(); })
            .observe(document.body, { childList: true, subtree: true });
    });
});