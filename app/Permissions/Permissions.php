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

    // Available apps: pages, wiki, intranet, blog, jobs

    /**
     * System permissions:
     */
    public const SYSTEM_SUPER_ADMIN = 'system.super.admin';

    public const SYSTEM_ADMIN = 'system.admin';
    public const SYSTEM_ACCESS_ADMIN_PANEL = 'system.access.admin.panel';
    public const SYSTEM_ACCESS_ADMIN_STATS = 'system.access.admin.stats';

    public const SYSTEM_ASSIGN_ROLES = 'system.assign.roles';

    public const SYSTEM_CREATE_ROLES = 'system.create.roles';
    public const SYSTEM_EDIT_ROLES = 'system.edit.roles';
    public const SYSTEM_DELETE_ROLES = 'system.delete.roles';

    public const SYSTEM_CREATE_USERS = 'system.create.users';
    public const SYSTEM_EDIT_USERS = 'system.edit.users';
    public const SYSTEM_DELETE_USERS = 'system.delete.users';
    public const SYSTEM_ENABLE_USERS = 'system.enable.users';
    public const SYSTEM_DISABLE_USERS = 'system.disable.users';

    public const SYSTEM_ENABLE_APPS = 'system.enable.apps';
    public const SYSTEM_DISABLE_APPS = 'system.disable.apps';




    /**
     * App specific permissions (Pages):
     */
    public const APP_PAGES_ACCESS_FRONTEND = 'app.pages.access.frontend';
    public const APP_PAGES_ACCESS_ADMIN_PANEL = 'app.pages.access.admin.panel';

    public const APP_PAGES_CREATE_PAGES = 'app.pages.create.pages';
    public const APP_PAGES_EDIT_PAGES = 'app.pages.edit.pages';
    public const APP_PAGES_DELETE_PAGES = 'app.pages.delete.pages';

    public const APP_PAGES_CREATE_MENUS = 'app.pages.create.menus';
    public const APP_PAGES_EDIT_MENUS = 'app.pages.edit.menus';
    public const APP_PAGES_DELETE_MENUS = 'app.pages.delete.menus';



    /**
     * App specific permissions (Wiki):
     */
    public const APP_WIKI_ACCESS_FRONTEND = 'app.wiki.access.frontend';
    public const APP_WIKI_ACCESS_ADMIN_PANEL = 'app.wiki.access.admin.panel';

    public const APP_WIKI_CREATE_PAGES = 'app.wiki.create.pages';
    public const APP_WIKI_EDIT_PAGES = 'app.wiki.edit.pages';
    public const APP_WIKI_DELETE_PAGES = 'app.wiki.delete.pages';

    public const APP_WIKI_CREATE_CATEGORIES = 'app.wiki.create.categories';
    public const APP_WIKI_EDIT_CATEGORIES = 'app.wiki.edit.categories';
    public const APP_WIKI_DELETE_CATEGORIES = 'app.wiki.delete.categories';



    /**
     * App specific permissions (Intranet):
     */
    public const APP_INTRANET_ACCESS_FRONTEND = 'app.intranet.access.frontend';
    public const APP_INTRANET_ACCESS_ADMIN_PANEL = 'app.intranet.access.admin.panel';

    public const APP_INTRANET_CREATE_POSTS = 'app.intranet.create.posts';
    public const APP_INTRANET_EDIT_POSTS = 'app.intranet.edit.posts';
    public const APP_INTRANET_DELETE_POSTS = 'app.intranet.delete.posts';

    public const APP_INTRANET_CREATE_CATEGORIES = 'app.intranet.create.categories';
    public const APP_INTRANET_EDIT_CATEGORIES = 'app.intranet.edit.categories';
    public const APP_INTRANET_DELETE_CATEGORIES = 'app.intranet.delete.categories';



    /**
     * App specific permissions (Blog):
     */
    public const APP_BLOG_ACCESS_FRONTEND = 'app.blog.access.frontend';
    public const APP_BLOG_ACCESS_ADMIN_PANEL = 'app.blog.access.admin.panel';

    public const APP_BLOG_CREATE_POSTS = 'app.blog.create.posts';
    public const APP_BLOG_EDIT_POSTS = 'app.blog.edit.posts';
    public const APP_BLOG_DELETE_POSTS = 'app.blog.delete.posts';

    public const APP_BLOG_CREATE_CATEGORIES = 'app.blog.create.categories';
    public const APP_BLOG_EDIT_CATEGORIES = 'app.blog.edit.categories';
    public const APP_BLOG_DELETE_CATEGORIES = 'app.blog.delete.categories';



    /**
     * App specific permissions (Jobs):
     */
    public const APP_JOBS_ACCESS_FRONTEND = 'app.jobs.access.frontend';
    public const APP_JOBS_ACCESS_ADMIN_PANEL = 'app.jobs.access.admin.panel';

    public const APP_JOBS_CREATE_OFFERS = 'app.jobs.create.offers';
    public const APP_JOBS_EDIT_OFFERS = 'app.jobs.edit.offers';
    public const APP_JOBS_DELETE_OFFERS = 'app.jobs.delete.offers';

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
                    ['id' => 0, 'name' => self::SYSTEM_SUPER_ADMIN, 'label' => 'Super Admin', 'description' => 'Der Super Admin ist der Wurzelnutzer des Systems und hat uneingeschränkten Zugriff auf alle Bereiche.'],
                ],
                [
                    ['id' => 1, 'name' => self::SYSTEM_ADMIN, 'label' => 'Admin', 'description' => 'Der Admin hat Zugriff auf alle Bereiche des Systems. und kann Benutzer und Rollen verwalten.'],
                    ['id' => 2, 'name' => self::SYSTEM_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Admin Bereich.'],
                    ['id' => 3, 'name' => self::SYSTEM_ACCESS_ADMIN_STATS, 'label' => 'Zutritt zu den Statistiken', 'description' => 'Der Benutzer hat Zugriff auf die Statistiken.'],
                ],
                [
                    ['id' => 4, 'name' => self::SYSTEM_ASSIGN_ROLES, 'label' => 'Rollen zuweisen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen zuweisen.'],
                    ['id' => 5, 'name' => self::SYSTEM_CREATE_ROLES, 'label' => 'Rollen erstellen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen erstellen.'],
                    ['id' => 6, 'name' => self::SYSTEM_EDIT_ROLES, 'label' => 'Rollen bearbeiten', 'description' => 'Der Benutzer kann anderen Benutzern Rollen bearbeiten.'],
                    ['id' => 7, 'name' => self::SYSTEM_DELETE_ROLES, 'label' => 'Rollen löschen', 'description' => 'Der Benutzer kann anderen Benutzern Rollen löschen.'],
                ],
                [
                    ['id' => 8, 'name' => self::SYSTEM_CREATE_USERS, 'label' => 'Benutzer erstellen', 'description' => 'Der Benutzer kann andere Benutzer erstellen.'],
                    ['id' => 9, 'name' => self::SYSTEM_EDIT_USERS, 'label' => 'Benutzer bearbeiten', 'description' => 'Der Benutzer kann andere Benutzer bearbeiten.'],
                    ['id' => 10, 'name' => self::SYSTEM_DELETE_USERS, 'label' => 'Benutzer löschen', 'description' => 'Der Benutzer kann andere Benutzer löschen.'],
                    ['id' => 11, 'name' => self::SYSTEM_ENABLE_USERS, 'label' => 'Benutzer aktivieren', 'description' => 'Der Benutzer kann andere Benutzer aktivieren.'],
                    ['id' => 12, 'name' => self::SYSTEM_DISABLE_USERS, 'label' => 'Benutzer deaktivieren', 'description' => 'Der Benutzer kann andere Benutzer deaktivieren.'],
                ],
                [
                    ['id' => 13, 'name' => self::SYSTEM_ENABLE_APPS, 'label' => 'Apps aktivieren', 'description' => 'Der Benutzer kann Apps aktivieren.'],
                    ['id' => 14, 'name' => self::SYSTEM_DISABLE_APPS, 'label' => 'Apps deaktivieren', 'description' => 'Der Benutzer kann Apps deaktivieren.'],
                ],
            ],
        ],

        'app.pages' => [
            'title' => 'Pages',
            'permissions' => [
                [
                    ['id' => 10001, 'name' => self::APP_PAGES_ACCESS_FRONTEND, 'label' => 'Zutritt zum Pages', 'description' => 'Der Benutzer hat Zugriff auf das Pages Frontend.'],
                    ['id' => 10002, 'name' => self::APP_PAGES_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Pages Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Pages Admin Bereich.'],
                ],
                [
                    ['id' => 10003, 'name' => self::APP_PAGES_CREATE_PAGES, 'label' => 'Seiten erstellen', 'description' => 'Der Benutzer kann Seiten erstellen.'],
                    ['id' => 10004, 'name' => self::APP_PAGES_EDIT_PAGES, 'label' => 'Seiten bearbeiten', 'description' => 'Der Benutzer kann Seiten bearbeiten.'],
                    ['id' => 10005, 'name' => self::APP_PAGES_DELETE_PAGES, 'label' => 'Seiten löschen', 'description' => 'Der Benutzer kann Seiten löschen.'],
                ],
                [
                    ['id' => 10006, 'name' => self::APP_PAGES_CREATE_MENUS, 'label' => 'Menüs erstellen', 'description' => 'Der Benutzer kann Menüs erstellen.'],
                    ['id' => 10007, 'name' => self::APP_PAGES_EDIT_MENUS, 'label' => 'Menüs bearbeiten', 'description' => 'Der Benutzer kann Menüs bearbeiten.'],
                    ['id' => 10008, 'name' => self::APP_PAGES_DELETE_MENUS, 'label' => 'Menüs löschen', 'description' => 'Der Benutzer kann Menüs löschen.'],
                ],
            ],
        ],

        'app.wiki' => [
            'title' => 'Wiki',
            'permissions' => [
                [
                    ['id' => 20001, 'name' => self::APP_WIKI_ACCESS_FRONTEND, 'label' => 'Zutritt zum Wiki', 'description' => 'Der Benutzer hat Zugriff auf das Frontend.'],
                    ['id' => 20002, 'name' => self::APP_WIKI_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Wiki Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Wiki Admin Bereich.'],
                ],
                [
                    ['id' => 20003, 'name' => self::APP_WIKI_CREATE_PAGES, 'label' => 'Seiten erstellen', 'description' => 'Der Benutzer kann Seiten erstellen.'],
                    ['id' => 20004, 'name' => self::APP_WIKI_EDIT_PAGES, 'label' => 'Seiten bearbeiten', 'description' => 'Der Benutzer kann Seiten bearbeiten.'],
                    ['id' => 20005, 'name' => self::APP_WIKI_DELETE_PAGES, 'label' => 'Seiten löschen', 'description' => 'Der Benutzer kann Seiten löschen.'],
                ],
                [
                    ['id' => 20006, 'name' => self::APP_WIKI_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['id' => 20007, 'name' => self::APP_WIKI_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['id' => 20008, 'name' => self::APP_WIKI_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.intranet' => [
            'title' => 'Intranet',
            'permissions' => [
                [
                    ['id' => 30001, 'name' => self::APP_INTRANET_ACCESS_FRONTEND, 'label' => 'Zutritt zum Intranet', 'description' => 'Der Benutzer hat Zugriff auf das Intranet Frontend.'],
                    ['id' => 30002, 'name' => self::APP_INTRANET_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Intranet Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Intranet Admin Bereich.'],
                ],
                [
                    ['id' => 30003, 'name' => self::APP_INTRANET_CREATE_POSTS, 'label' => 'Beiträge erstellen', 'description' => 'Der Benutzer kann Beiträge erstellen.'],
                    ['id' => 30004, 'name' => self::APP_INTRANET_EDIT_POSTS, 'label' => 'Beiträge bearbeiten', 'description' => 'Der Benutzer kann Beiträge bearbeiten.'],
                    ['id' => 30005, 'name' => self::APP_INTRANET_DELETE_POSTS, 'label' => 'Beiträge löschen', 'description' => 'Der Benutzer kann Beiträge löschen.'],
                ],
                [
                    ['id' => 30006, 'name' => self::APP_INTRANET_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['id' => 30007, 'name' => self::APP_INTRANET_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['id' => 30008, 'name' => self::APP_INTRANET_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.blog' => [
            'title' => 'Blog',
            'permissions' => [
                [
                    ['id' => 40001, 'name' => self::APP_BLOG_ACCESS_FRONTEND, 'label' => 'Zutritt zum Blog', 'description' => 'Der Benutzer hat Zugriff auf das Blog Frontend.'],
                    ['id' => 40002, 'name' => self::APP_BLOG_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Blog Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Blog Admin Bereich.'],
                ],
                [
                    ['id' => 40003, 'name' => self::APP_BLOG_CREATE_POSTS, 'label' => 'Beiträge erstellen', 'description' => 'Der Benutzer kann Beiträge erstellen.'],
                    ['id' => 40004, 'name' => self::APP_BLOG_EDIT_POSTS, 'label' => 'Beiträge bearbeiten', 'description' => 'Der Benutzer kann Beiträge bearbeiten.'],
                    ['id' => 40005, 'name' => self::APP_BLOG_DELETE_POSTS, 'label' => 'Beiträge löschen', 'description' => 'Der Benutzer kann Beiträge löschen.'],
                ],
                [
                    ['id' => 40006, 'name' => self::APP_BLOG_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['id' => 40007, 'name' => self::APP_BLOG_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['id' => 40008, 'name' => self::APP_BLOG_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],

        'app.jobs' => [
            'title' => 'Jobs',
            'permissions' => [
                [
                    ['id' => 50001, 'name' => self::APP_JOBS_ACCESS_FRONTEND, 'label' => 'Zutritt zu Jobs', 'description' => 'Der Benutzer hat Zugriff auf das Jobs Frontend.'],
                    ['id' => 50002, 'name' => self::APP_JOBS_ACCESS_ADMIN_PANEL, 'label' => 'Zutritt zum Jobs Admin Bereich', 'description' => 'Der Benutzer hat Zugriff auf den Jobs Admin Bereich.'],
                ],
                [
                    ['id' => 50003, 'name' => self::APP_JOBS_CREATE_OFFERS, 'label' => 'Angebote erstellen', 'description' => 'Der Benutzer kann Angebote erstellen.'],
                    ['id' => 50004, 'name' => self::APP_JOBS_EDIT_OFFERS, 'label' => 'Angebote bearbeiten', 'description' => 'Der Benutzer kann Angebote bearbeiten.'],
                    ['id' => 50005, 'name' => self::APP_JOBS_DELETE_OFFERS, 'label' => 'Angebote löschen', 'description' => 'Der Benutzer kann Angebote löschen.'],
                ],
                [
                    ['id' => 50006, 'name' => self::APP_JOBS_CREATE_CATEGORIES, 'label' => 'Kategorien erstellen', 'description' => 'Der Benutzer kann Kategorien erstellen.'],
                    ['id' => 50007, 'name' => self::APP_JOBS_EDIT_CATEGORIES, 'label' => 'Kategorien bearbeiten', 'description' => 'Der Benutzer kann Kategorien bearbeiten.'],
                    ['id' => 50008, 'name' => self::APP_JOBS_DELETE_CATEGORIES, 'label' => 'Kategorien löschen', 'description' => 'Der Benutzer kann Kategorien löschen.'],
                ],
            ],
        ],
    ];



    public static function getPermissionsList()
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
                    $permissions[] = $permission['name'];
                }
            }
        }

        return $permissions;
    }
}