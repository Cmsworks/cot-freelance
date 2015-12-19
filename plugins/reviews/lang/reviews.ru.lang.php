<?php
/**
 * Reviews plugin
 *
 * @package reviews
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Module Config
 */
$L['cfg_checkprojects'] = 'Разрешить добавлять отзывы только при наличии совместных проектов';
$L['cfg_userall'] = 'Отображать на странице пользователя все отзывы';

$L['reviews_chooseprj'] = 'Выберите проект';
$L['reviews_reviewforproject'] = 'Отзыв за';
$L['reviews_projectsonly'] = 'Отзывы можно оставлять только за проекты, по которым вы сотрудничали.';
$L['reviews_text'] = 'Текст отзыва';
$L['reviews_score'] = 'Оценка';
$L['reviews_review'] = 'Отзыв';
$L['reviews_reviews'] = 'Отзывы';
$L['reviews_add_review'] = 'Добавить отзыв';
$L['reviews_edit_review'] = 'Редактировать отзыв';

$L['reviews_score_values'] = array(1, -1);
$L['reviews_score_titles'] = array('Положительный', 'Негативный');

$L['reviews_error_toyourself'] = 'Нельзя оставить отзыв самому себе';
$L['reviews_error_projectsonly'] = 'Отзывы можно оставлять только за проекты, по которым вы сотрудничали';
$L['reviews_error_exists'] = 'Отзыв уже создан';
$L['reviews_error_emptytext'] = 'Отзыв не может быть пустым';
$L['reviews_error_emptyscore'] = 'Укажите оценку';