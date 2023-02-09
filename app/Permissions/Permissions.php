<?php

namespace App\Permissions;

class Permissions
{
    // Depricated
    public const CAN_ACCESS_ADMIN_PANEL = 'access admin panel';
    public const CAN_EDIT_JOB_OFFERS = 'edit job offers';
    public const CAN_EDIT_SPECS = 'edit specs';
    public const CAN_EDIT_USERS = 'edit users';
    public const CAN_EDIT_DOCS = 'edit docs';
    public const CAN_EDIT_POSTS = 'edit posts';

    /**
     * System permissions:
     */
    public const SYSTEM_SUPER_ADMIN = 'system.super-admin';

    public const SYSTEM_ADMIN = 'system.admin';
    public const SYSTEM_ACCESS_ADMIN_PANEL = 'system.access.admin.panel';
    public const SYSTEM_ACCESS_ADMIN_STATS = 'system.access.admin.stats';

    public const SYSTEM_VIEW_ROLES = 'system.view.roles';
    public const SYSTEM_ASSIGN_ROLES = 'system.assign.roles';
    public const SYSTEM_CREATE_ROLES = 'system.create.roles';
    public const SYSTEM_EDIT_ROLES = 'system.edit.roles';
    public const SYSTEM_DELETE_ROLES = 'system.delete.roles';

    public const SYSTEM_VIEW_USERS = 'system.view.users';
    public const SYSTEM_CREATE_USERS = 'system.create.users';
    public const SYSTEM_EDIT_USERS = 'system.edit.users';
    public const SYSTEM_DELETE_USERS = 'system.delete.users';
    public const SYSTEM_ENABLE_USERS = 'system.enable.users';
    public const SYSTEM_DISABLE_USERS = 'system.disable.users';

    public const SYSTEM_VIEW_SETTINGS = 'system.view.settings';
    public const SYSTEM_EDIT_SETTINGS = 'system.edit.settings';
    public const SYSTEM_ENABLE_APPS = 'system.enable.apps';
    public const SYSTEM_DISABLE_APPS = 'system.disable.apps';

    public const SYSTEM_VIEW_MEDIA = 'system.view.media';
    public const SYSTEM_UPLOAD_MEDIA = 'system.upload.media';
    public const SYSTEM_EDIT_MEDIA = 'system.edit.media';
    public const SYSTEM_DELETE_MEDIA = 'system.delete.media';




    /**
     * App specific permissions (Pages):
     */
    public const APP_PAGES_ACCESS_FRONTEND = 'app.pages.access.frontend';
    public const APP_PAGES_ACCESS_ADMIN_PANEL = 'app.pages.access.admin.panel';

    public const APP_PAGES_VIEW_PAGES = 'app.pages.view.pages';
    public const APP_PAGES_CREATE_PAGES = 'app.pages.create.pages';
    public const APP_PAGES_EDIT_PAGES = 'app.pages.edit.pages';
    public const APP_PAGES_DELETE_PAGES = 'app.pages.delete.pages';

    public const APP_PAGES_VIEW_MENUS = 'app.pages.view.menus';
    public const APP_PAGES_CREATE_MENUS = 'app.pages.create.menus';
    public const APP_PAGES_EDIT_MENUS = 'app.pages.edit.menus';
    public const APP_PAGES_DELETE_MENUS = 'app.pages.delete.menus';



    /**
     * App specific permissions (Forms):
     */
    public const APP_FORMS_ACCESS_FRONTEND = 'app.forms.access.frontend';
    public const APP_FORMS_ACCESS_ADMIN_PANEL = 'app.forms.access.admin.panel';

    public const APP_FORMS_VIEW_FORMS = 'app.forms.view.forms';
    public const APP_FORMS_CREATE_FORMS = 'app.forms.create.forms';
    public const APP_FORMS_EDIT_FORMS = 'app.forms.edit.forms';
    public const APP_FORMS_DELETE_FORMS = 'app.forms.delete.forms';

    public const APP_FORMS_VIEW_SUBMISSIONS = 'app.forms.view.submissions';
    public const APP_FORMS_DELETE_SUBMISSIONS = 'app.forms.delete.submissions';



    /**
     * App specific permissions (Wiki):
     */
    public const APP_WIKI_ACCESS_FRONTEND = 'app.wiki.access.frontend';
    public const APP_WIKI_ACCESS_ADMIN_PANEL = 'app.wiki.access.admin.panel';

    public const APP_WIKI_VIEW_PAGES = 'app.wiki.view.pages';
    public const APP_WIKI_CREATE_PAGES = 'app.wiki.create.pages';
    public const APP_WIKI_EDIT_PAGES = 'app.wiki.edit.pages';
    public const APP_WIKI_DELETE_PAGES = 'app.wiki.delete.pages';

    public const APP_WIKI_VIEW_CATEGORIES = 'app.wiki.view.categories';
    public const APP_WIKI_CREATE_CATEGORIES = 'app.wiki.create.categories';
    public const APP_WIKI_EDIT_CATEGORIES = 'app.wiki.edit.categories';
    public const APP_WIKI_DELETE_CATEGORIES = 'app.wiki.delete.categories';



    /**
     * App specific permissions (Intranet):
     */
    public const APP_INTRANET_ACCESS_FRONTEND = 'app.intranet.access.frontend';
    public const APP_INTRANET_ACCESS_ADMIN_PANEL = 'app.intranet.access.admin.panel';

    public const APP_INTRANET_VIEW_POSTS = 'app.intranet.view.posts';
    public const APP_INTRANET_CREATE_POSTS = 'app.intranet.create.posts';
    public const APP_INTRANET_EDIT_POSTS = 'app.intranet.edit.posts';
    public const APP_INTRANET_DELETE_POSTS = 'app.intranet.delete.posts';

    public const APP_INTRANET_VIEW_CATEGORIES = 'app.intranet.view.categories';
    public const APP_INTRANET_CREATE_CATEGORIES = 'app.intranet.create.categories';
    public const APP_INTRANET_EDIT_CATEGORIES = 'app.intranet.edit.categories';
    public const APP_INTRANET_DELETE_CATEGORIES = 'app.intranet.delete.categories';



    /**
     * App specific permissions (Blog):
     */
    public const APP_BLOG_ACCESS_FRONTEND = 'app.blog.access.frontend';
    public const APP_BLOG_ACCESS_ADMIN_PANEL = 'app.blog.access.admin.panel';

    public const APP_BLOG_VIEW_POSTS = 'app.blog.view.posts';
    public const APP_BLOG_CREATE_POSTS = 'app.blog.create.posts';
    public const APP_BLOG_EDIT_POSTS = 'app.blog.edit.posts';
    public const APP_BLOG_DELETE_POSTS = 'app.blog.delete.posts';

    public const APP_BLOG_VIEW_CATEGORIES = 'app.blog.view.categories';
    public const APP_BLOG_CREATE_CATEGORIES = 'app.blog.create.categories';
    public const APP_BLOG_EDIT_CATEGORIES = 'app.blog.edit.categories';
    public const APP_BLOG_DELETE_CATEGORIES = 'app.blog.delete.categories';



    /**
     * App specific permissions (Jobs):
     */
    public const APP_JOBS_ACCESS_FRONTEND = 'app.jobs.access.frontend';
    public const APP_JOBS_ACCESS_ADMIN_PANEL = 'app.jobs.access.admin.panel';

    public const APP_JOBS_VIEW_OFFERS = 'app.jobs.view.offers';
    public const APP_JOBS_CREATE_OFFERS = 'app.jobs.create.offers';
    public const APP_JOBS_EDIT_OFFERS = 'app.jobs.edit.offers';
    public const APP_JOBS_DELETE_OFFERS = 'app.jobs.delete.offers';

    public const APP_JOBS_VIEW_CATEGORIES = 'app.jobs.view.categories';
    public const APP_JOBS_CREATE_CATEGORIES = 'app.jobs.create.categories';
    public const APP_JOBS_EDIT_CATEGORIES = 'app.jobs.edit.categories';
    public const APP_JOBS_DELETE_CATEGORIES = 'app.jobs.delete.categories';



    /**
     * Permissions setup:
     */

    public const GROUPED_PERMISSIONS = [
        'system' => [
            'title' => 'System',
            'permissions' => [
                [
                    ['name' => self::SYSTEM_SUPER_ADMIN, 'label' => 'Super Admin', 'description' => 'Der Super Admin hat Zugriff auf alle Bereiche des Systems und kann Benutzer und Rollen verwalten.'],
                    ['name' => self::SYSTEM_ADMIN, 'label' => 'Admin', 'description' => 'Der Admin hat Zugriff auf alle Bereiche des Systems und kann Benutzer und Rollen verwalten.'],
                ],
                [
                    ['name' => self::SYSTEM_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Admin Bereich.'],
                    ['name' => self::SYSTEM_ACCESS_ADMIN_STATS, 'label' => 'Zutritt zu den Statistiken', 'description' => 'Der Benutzer hat Zugriff auf die Statistiken.'],
                ],
                [
                    ['name' => self::SYSTEM_VIEW_ROLES, 'label' => 'Rollen anzeigen', 'description' => 'Der Benutzer kann die Rollen ansehen.'],
                    ['name' => self::SYSTEM_ASSIGN_ROLES, 'label' => 'Rollen zuweisen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen zuweisen.'],
                    ['name' => self::SYSTEM_CREATE_ROLES, 'label' => 'Rollen erstellen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen erstellen.'],
                    ['name' => self::SYSTEM_EDIT_ROLES, 'label' => 'Rollen bearbeiten', 'description' => 'Der Benutzer kann anderen Benutzern Rollen bearbeiten.'],
                    ['name' => self::SYSTEM_DELETE_ROLES, 'label' => 'Rollen löschen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen löschen.'],
                ],
                [
                    ['name' => self::SYSTEM_VIEW_USERS, 'label' => 'Benutzer anzeigen', 'description' => 'Der Benutzer kann andere Benutzer ansehen.'],
                    ['name' => self::SYSTEM_CREATE_USERS, 'label' => 'Benutzer erstellen', 'description' => 'Der Benutzer kann andere Benutzer erstellen.'],
                    ['name' => self::SYSTEM_EDIT_USERS, 'label' => 'Benutzer bearbeiten', 'description' => 'Der Benutzer kann andere Benutzer bearbeiten.'],
                    ['name' => self::SYSTEM_DELETE_USERS, 'label' => 'Benutzer löschen', 'description' => 'Der Benutzer kann andere Benutzer löschen.'],
                    ['name' => self::SYSTEM_ENABLE_USERS, 'label' => 'Benutzer aktivieren', 'description' => 'Der Benutzer kann andere Benutzer aktivieren.'],
                    ['name' => self::SYSTEM_DISABLE_USERS, 'label' => 'Benutzer deaktivieren', 'description' => 'Der Benutzer kann andere Benutzer deaktivieren.'],
                ],
                [
                    ['name' => self::SYSTEM_VIEW_SETTINGS, 'label' => 'Einstellungen anzeigen', 'description' => 'Der Benutzer kann die Einstellungen ansehen.'],
                    ['name' => self::SYSTEM_EDIT_SETTINGS, 'label' => 'Einstellungen bearbeiten', 'description' => 'Der Benutzer kann die Einstellungen bearbeiten.'],
                    ['name' => self::SYSTEM_ENABLE_APPS, 'label' => 'Apps aktivieren', 'description' => 'Der Benutzer kann Apps aktivieren.'],
                    ['name' => self::SYSTEM_DISABLE_APPS, 'label' => 'Apps deaktivieren', 'description' => 'Der Benutzer kann Apps deaktivieren.'],
                ],
                [
                    ['name' => self::SYSTEM_VIEW_MEDIA, 'label' => 'Medien anzeigen', 'description' => 'Der Benutzer kann die Medien ansehen.'],
                    ['name' => self::SYSTEM_UPLOAD_MEDIA, 'label' => 'Medien hochladen', 'description' => 'Der Benutzer kann Medien hochladen.'],
                    ['name' => self::SYSTEM_EDIT_MEDIA, 'label' => 'Medien bearbeiten', 'description' => 'Der Benutzer kann Medien bearbeiten.'],
                    ['name' => self::SYSTEM_DELETE_MEDIA, 'label' => 'Medien löschen', 'description' => 'Der Benutzer kann Medien löschen.'],
                ],
            ],
        ],

        'app.pages' => [
            'title' => 'Pages',
            'permissions' => [
                [
                    ['name' => self::APP_PAGES_ACCESS_FRONTEND, 'label' => 'Zutritt zu Pages', 'description' => 'Der Benutzer hat Zugriff auf das Pages Frontend.'],
                    ['name' => self::APP_PAGES_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Pages Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Pages Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_PAGES_VIEW_PAGES, 'label' => 'Seiten anzeigen', 'description' => 'Der Benutzer kann Seiten ansehen.'],
                    ['name' => self::APP_PAGES_CREATE_PAGES, 'label' => 'Seiten erstellen', 'description' => 'Der Benutzer kann Seiten erstellen.'],
                    ['name' => self::APP_PAGES_EDIT_PAGES, 'label' => 'Seiten bearbeiten', 'description' => 'Der Benutzer kann Seiten bearbeiten.'],
                    ['name' => self::APP_PAGES_DELETE_PAGES, 'label' => 'Seiten löschen', 'description' => 'Der Benutzer kann Seiten löschen.'],
                ],
                [
                    ['name' => self::APP_PAGES_VIEW_MENUS, 'label' => 'Menüs anzeigen', 'description' => 'Der Benutzer kann Menüs ansehen.'],
                    ['name' => self::APP_PAGES_CREATE_MENUS, 'label' => 'Menüs erstellen', 'description' => 'Der Benutzer kann Menüs erstellen.'],
                    ['name' => self::APP_PAGES_EDIT_MENUS, 'label' => 'Menüs bearbeiten', 'description' => 'Der Benutzer kann Menüs bearbeiten.'],
                    ['name' => self::APP_PAGES_DELETE_MENUS, 'label' => 'Menüs löschen', 'description' => 'Der Benutzer kann Menüs löschen.'],
                ],
            ],
        ],

        'app.forms' => [
            'title' => 'Forms',
            'permissions' => [
                [
                    ['name' => self::APP_FORMS_ACCESS_FRONTEND, 'label' => 'Zutritt zu Forms', 'description' => 'Der Benutzer hat Zugriff auf das Forms Frontend.'],
                    ['name' => self::APP_FORMS_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Forms Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Forms Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_FORMS_VIEW_FORMS, 'label' => 'Formulare anzeigen', 'description' => 'Der Benutzer kann Formulare ansehen.'],
                    ['name' => self::APP_FORMS_CREATE_FORMS, 'label' => 'Formulare erstellen', 'description' => 'Der Benutzer kann Formulare erstellen.'],
                    ['name' => self::APP_FORMS_EDIT_FORMS, 'label' => 'Formulare bearbeiten', 'description' => 'Der Benutzer kann Formulare bearbeiten.'],
                    ['name' => self::APP_FORMS_DELETE_FORMS, 'label' => 'Formulare löschen', 'description' => 'Der Benutzer kann Formulare löschen.'],
                ],
                [
                    ['name' => self::APP_FORMS_VIEW_SUBMISSIONS, 'label' => 'Einsendungen anzeigen', 'description' => 'Der Benutzer kann Einsendungen ansehen.'],
                    ['name' => self::APP_FORMS_DELETE_SUBMISSIONS, 'label' => 'Einsendungen löschen', 'description' => 'Der Benutzer kann Einsendungen löschen.'],
                ],
            ],
        ],

        'app.wiki' => [
            'title' => 'Wiki',
            'permissions' => [
                [
                    ['name' => self::APP_WIKI_ACCESS_FRONTEND, 'label' => 'Zutritt zum Wiki', 'description' => 'Der Benutzer hat Zugriff auf das Frontend.'],
                    ['name' => self::APP_WIKI_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Wiki Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Wiki Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_WIKI_VIEW_PAGES, 'label' => 'Seiten anzeigen', 'description' => 'Der Benutzer kann Seiten ansehen.'],
                    ['name' => self::APP_WIKI_CREATE_PAGES, 'label' => 'Seiten erstellen', 'description' => 'Der Benutzer kann Seiten erstellen.'],
                    ['name' => self::APP_WIKI_EDIT_PAGES, 'label' => 'Seiten bearbeiten', 'description' => 'Der Benutzer kann Seiten bearbeiten.'],
                    ['name' => self::APP_WIKI_DELETE_PAGES, 'label' => 'Seiten löschen', 'description' => 'Der Benutzer kann Seiten löschen.'],
                ],
                [
                    ['name' => self::APP_WIKI_VIEW_CATEGORIES, 'label' => 'Kategorien anzeigen', 'description' => 'Der Benutzer kann Kategorien ansehen.'],
                    ['name' => self::APP_WIKI_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['name' => self::APP_WIKI_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['name' => self::APP_WIKI_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.intranet' => [
            'title' => 'Intranet',
            'permissions' => [
                [
                    ['name' => self::APP_INTRANET_ACCESS_FRONTEND, 'label' => 'Zutritt zum Intranet', 'description' => 'Der Benutzer hat Zugriff auf das Intranet Frontend.'],
                    ['name' => self::APP_INTRANET_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Intranet Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Intranet Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_INTRANET_VIEW_POSTS, 'label' => 'Beiträge anzeigen', 'description' => 'Der Benutzer kann Beiträge ansehen.'],
                    ['name' => self::APP_INTRANET_CREATE_POSTS, 'label' => 'Beiträge erstellen', 'description' => 'Der Benutzer kann Beiträge erstellen.'],
                    ['name' => self::APP_INTRANET_EDIT_POSTS, 'label' => 'Beiträge bearbeiten', 'description' => 'Der Benutzer kann Beiträge bearbeiten.'],
                    ['name' => self::APP_INTRANET_DELETE_POSTS, 'label' => 'Beiträge löschen', 'description' => 'Der Benutzer kann Beiträge löschen.'],
                ],
                [
                    ['name' => self::APP_INTRANET_VIEW_CATEGORIES, 'label' => 'Kategorien anzeigen', 'description' => 'Der Benutzer kann Kategorien ansehen.'],
                    ['name' => self::APP_INTRANET_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['name' => self::APP_INTRANET_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['name' => self::APP_INTRANET_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.blog' => [
            'title' => 'Blog',
            'permissions' => [
                [
                    ['name' => self::APP_BLOG_ACCESS_FRONTEND, 'label' => 'Zutritt zum Blog', 'description' => 'Der Benutzer hat Zugriff auf das Blog Frontend.'],
                    ['name' => self::APP_BLOG_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Blog Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Blog Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_BLOG_VIEW_POSTS, 'label' => 'Beiträge anzeigen', 'description' => 'Der Benutzer kann Beiträge ansehen.'],
                    ['name' => self::APP_BLOG_CREATE_POSTS, 'label' => 'Beiträge erstellen', 'description' => 'Der Benutzer kann Beiträge erstellen.'],
                    ['name' => self::APP_BLOG_EDIT_POSTS, 'label' => 'Beiträge bearbeiten', 'description' => 'Der Benutzer kann Beiträge bearbeiten.'],
                    ['name' => self::APP_BLOG_DELETE_POSTS, 'label' => 'Beiträge löschen', 'description' => 'Der Benutzer kann Beiträge löschen.'],
                ],
                [
                    ['name' => self::APP_BLOG_VIEW_CATEGORIES, 'label' => 'Kategorien anzeigen', 'description' => 'Der Benutzer kann Kategorien ansehen.'],
                    ['name' => self::APP_BLOG_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['name' => self::APP_BLOG_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['name' => self::APP_BLOG_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.jobs' => [
            'title' => 'Jobs',
            'permissions' => [
                [
                    ['name' => self::APP_JOBS_ACCESS_FRONTEND, 'label' => 'Zutritt zu Jobs', 'description' => 'Der Benutzer hat Zugriff auf das Jobs Frontend.'],
                    ['name' => self::APP_JOBS_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Jobs Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Jobs Admin Bereich.'],
                ],
                [
                    ['name' => self::APP_JOBS_VIEW_OFFERS, 'label' => 'Angebote anzeigen', 'description' => 'Der Benutzer kann Angebote ansehen.'],
                    ['name' => self::APP_JOBS_CREATE_OFFERS, 'label' => 'Angebote erstellen', 'description' => 'Der Benutzer kann Angebote erstellen.'],
                    ['name' => self::APP_JOBS_EDIT_OFFERS, 'label' => 'Angebote bearbeiten', 'description' => 'Der Benutzer kann Angebote bearbeiten.'],
                    ['name' => self::APP_JOBS_DELETE_OFFERS, 'label' => 'Angebote löschen', 'description' => 'Der Benutzer kann Angebote löschen.'],
                ],
                [
                    ['name' => self::APP_JOBS_VIEW_CATEGORIES, 'label' => 'Kategorien anzeigen', 'description' => 'Der Benutzer kann Kategorien ansehen.'],
                    ['name' => self::APP_JOBS_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['name' => self::APP_JOBS_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['name' => self::APP_JOBS_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],
    ];



    public static function getPermissionsList($extendedInfo = false)
    {
        $groupedPermissions = self::GROUPED_PERMISSIONS;
        
        // flatten permissions
        $permissions = [];

        foreach ($groupedPermissions as $group)
        {
            foreach ($group['permissions'] as $permissionGroup)
            {
                foreach ($permissionGroup as $permission)
                {
                    $permissions[] = ($extendedInfo ? $permission : $permission['name']);
                }
            }
        }

        return $permissions;
    }
}