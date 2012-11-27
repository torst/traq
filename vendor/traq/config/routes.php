<?php
/*!
 * Traq
 * Copyright (C) 2009-2012 Traq.io
 *
 * This file is part of Traq.
 *
 * Traq is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Traq is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Traq. If not, see <http://www.gnu.org/licenses/>.
 */

use avalon\http\Router;

define("RTR_PROJSLUG", '(?P<project_slug>[a-zA-Z0-9\-\_]+)');

Router::add('root', 'traq::controllers::Projects.index');
Router::add('404', 'traq::controllers::Error.404');
Router::add('/(login|logout|register)', 'traq::controllers::Users.$1');
Router::add('/usercp', 'traq::controllers::Usercp.index');
Router::add('/usercp/password', 'traq::controllers::Usercp.password');
Router::add('/users/([0-9]+)', 'traq::controllers::Users.view/$1');

// Misc
Router::add('/_js(?:.js)?', 'traq::controllers::Misc.javascript');
Router::add('/_ajax/ticket_template/([0-9]+)', 'traq::controllers::Misc.ticket_template/$1');
Router::add('/_ajax/autocomplete/(username)', 'traq::controllers::Misc.autocomplete_$1');

// Attachment routes
Router::add('/attachments/(?P<attachment_id>[0-9]+)/([a-zA-Z0-9\-_.]+)', 'traq::controllers::Attachments.view/$1');
Router::add('/attachments/(?P<attachment_id>[0-9]+)/([a-zA-Z0-9\-_.\s]+)/delete', 'traq::controllers::Attachments.delete/$1');

// ------------------------------------------------
// Project routes
Router::add('/projects', 'traq::controllers::Projects.index');
Router::add('/' . RTR_PROJSLUG . '/milestone/(?P<milestone_slug>[a-zA-Z0-9\-_.]+?)', 'traq::controllers::Projects.milestone/$2');
Router::add('/' . RTR_PROJSLUG . '/(timeline|roadmap|changelog)', 'traq::controllers::Projects.$2');
Router::add('/' . RTR_PROJSLUG, 'traq::controllers::Projects.view');

// Ticket routes
Router::add('/' . RTR_PROJSLUG . '/tickets/new', 'traq::controllers::Tickets.new');
Router::add('/' . RTR_PROJSLUG . '/tickets/(?P<ticket_id>[0-9]+)', 'traq::controllers::Tickets.view/$2');
Router::add('/' . RTR_PROJSLUG . '/tickets/(?P<ticket_id>[0-9]+)/(update|edit|vote|voters)', 'traq::controllers::Tickets.$3/$2');
Router::add('/' . RTR_PROJSLUG . '/tickets/(?P<ticket_id>[0-9]+)/history/([0-9]+)/edit', 'traq::controllers::TicketHistory.edit/$3');
Router::add('/' . RTR_PROJSLUG . '/tickets/(?P<ticket_id>[0-9]+)/history/([0-9]+)/delete', 'traq::controllers::TicketHistory.delete/$3');
Router::add('/' . RTR_PROJSLUG . '/tickets', 'traq::controllers::Tickets.index');

// Wiki routes
Router::add('/' . RTR_PROJSLUG . '/wiki', 'traq::controllers::Wiki.index');
Router::add('/' . RTR_PROJSLUG . '/wiki/_pages', 'traq::controllers::Wiki.pages');
Router::add('/' . RTR_PROJSLUG . '/wiki/_new', 'traq::controllers::Wiki.new');
Router::add('/' . RTR_PROJSLUG . '/wiki/([a-zA-Z0-9\-\_]+)', 'traq::controllers::Wiki.view/$2');
Router::add('/' . RTR_PROJSLUG . '/wiki/([a-zA-Z0-9\-\_]+)/_edit', 'traq::controllers::Wiki.edit/$2');
Router::add('/' . RTR_PROJSLUG . '/wiki/([a-zA-Z0-9\-\_]+)/_delete', 'traq::controllers::Wiki.delete/$2');

// Project settings routes
Router::add('/' . RTR_PROJSLUG . '/settings', 'ProjectSettings::Options::index');
Router::add('/' . RTR_PROJSLUG . '/settings/(milestones|components|members|repositories)', 'ProjectSettings::$2::index');
Router::add('/' . RTR_PROJSLUG . '/settings/(milestones|components|members|repositories)/new', 'ProjectSettings::$2::new');
Router::add('/' . RTR_PROJSLUG . '/settings/(milestones|components|members)/([0-9]+)/(edit|delete)', 'ProjectSettings::$2::$4/$3');
Router::add('/' . RTR_PROJSLUG . '/settings/members/save', 'ProjectSettings::Members::save');

// Project permission routes
Router::add('/' . RTR_PROJSLUG . '/settings/permissions/(groups|roles)', 'ProjectSettings::Permissions::index/$2');

// ------------------------------------------------
// AdminCP routes
Router::add('/admin', 'traq::controllers::admin::Projects.index');
Router::add('/admin/settings', 'traq::controllers::admin::Settings.index');

// Projects
Router::add('/admin/projects/new', 'traq::controllers::admin::Projects.new');
Router::add('/admin/projects/([0-9]+)/delete', 'traq::controllers::admin::Projects.delete/$1');

// Plugins
Router::add('/admin/plugins', 'Admin::Plugins::index');
Router::add('/admin/plugins/(install|enable|disable|uninstall)/([a-zA-Z0-9\-\_]+)', 'Admin::Plugins::$1/$2');

// Users
Router::add('/admin/users', 'Admin::Users::index');
Router::add('/admin/users/new', 'Admin::Users::new');
Router::add('/admin/users/([0-9]+)/(edit|delete)', 'Admin::Users::$2/$1');

// User groups
Router::add('/admin/groups', 'Admin::Groups::index');
Router::add('/admin/groups/new', 'Admin::Groups::new');
Router::add('/admin/groups/([0-9]+)/(edit|delete)', 'Admin::Groups::$2/$1');

// Project roles
Router::add('/admin/roles', 'Admin::ProjectRoles::index');
Router::add('/admin/roles/new', 'Admin::ProjectRoles::new');
Router::add('/admin/roles/([0-9]+)/(edit|delete)', 'Admin::ProjectRoles::$2/$1');

// Ticket types
Router::add('/admin/tickets/types', 'Admin::Types::index');
Router::add('/admin/tickets/types/new', 'Admin::Types::new');
Router::add('/admin/tickets/types/([0-9]+)/(edit|delete)', 'Admin::Types::$2/$1');

// Ticket statuses
Router::add('/admin/tickets/statuses', 'Admin::Statuses::index');
Router::add('/admin/tickets/statuses/new', 'Admin::Statuses::new');
Router::add('/admin/tickets/statuses/([0-9]+)/(edit|delete)', 'Admin::Statuses::$2/$1');

// Severities
Router::add('/admin/severities', 'Admin::Severities::index');
Router::add('/admin/severities/new', 'Admin::Severities::new');
Router::add('/admin/severities/([0-9]+)/(edit|delete)', 'Admin::Severities::$2/$1');

// Priorities
Router::add('/admin/priorities', 'Admin::Priorities::index');
Router::add('/admin/priorities/new', 'Admin::Priorities::new');
Router::add('/admin/priorities/([0-9]+)/(edit|delete)', 'Admin::Priorities::$2/$1');
