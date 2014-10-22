<?php
/*!
 * Traq
 * Copyright (C) 2009-2014 Jack Polgar
 * Copyright (C) 2012-2014 Traq.io
 * https://github.com/nirix
 * http://traq.io
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

namespace Traq\Models;

use Radium\Database\Model;

/**
 * Wiki Page database model.
 *
 * @package TraqModels
 * @author Jack P. <jack@traq.io>
 * @copyright (c) Jack P. <jack@traq.io>
 */
class WikiPage extends Model
{
    protected static $_table = 'wiki';

    protected static $_hasMany = array(
        'revisions' => array(
            'model'      => "WikiRevision",
            'foreignKey' => 'wiki_page_id'
        )
    );

    protected static $_belongsTo = array(
        'project',
        'revision' => array('model' => "WikiRevision")
    );

    protected static $_validates = array(
        'title' => array('required'),
        'slug'  => array('required'),
    );

    protected static $_before = array(
        'create' => array('_setSlug'),
        'save'   => array('_setSlug')
    );

    /**
     * @param array   $data
     * @param boolean $is_new
     */
    public function __construct($data = array(), $isNew = true)
    {
        parent::__construct($data, $isNew);

        if ($isNew) {
            $this->_relationsCache['revision'] = new WikiRevision(array(
                'revision' => 1,
                'content'  => (isset($data['content']) ? $data['content'] : '')
            ));
        }
    }

    /**
     * Returns the URI for the page.
     *
     * @param string $uri Extra segments to be appended to the URI.
     *
     * @return string
     */
    public function href($uri = null)
    {
        return "/{$this->project()->slug}/wiki/{$this->slug}" . ($uri !== null ? '/' . implode('/', func_get_args()) : '');
    }

    /**
     * Removes spaces from the slug.
     */
    protected function _setSlug()
    {
        $this->slug = str_replace(' ', '_', $this->slug);
    }

    /**
     * Checks if the pages data is valid.
     *
     * @return bool
     */
    public function validates($data = null)
    {
        parent::validates($data);

        // Make sure the slug isnt in use..
        $checkSlug = static::select('id')
            ->where('id != ?', ($this->_isNew ? 0 : $this->id))
            ->_and('slug = ?', $this->slug)
            ->_and('project_id = ?', $this->project_id);

        if ($checkSlug->rowCount()) {
            $this->addError(
                'slug', 'unique',
                array('message' => "errors.validations.already_in_use")
            );
        }

        return count($this->errors) == 0;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function __toArray()
    {
        return [
            'id' => $this->id,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'main'       => $this->main,
            'project_id' => $this->project_id,
            'revision'   => $this->revision()->__toArray()
        ];
    }
}