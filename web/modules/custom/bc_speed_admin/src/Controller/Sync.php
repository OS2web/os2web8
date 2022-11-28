<?php
namespace Drupal\bc_speed_admin\Controller;

use Drupal\bc_speed_admin\Controller\Course;
use \Drupal\bc_speed_admin\Controller\Teacher;
use Drupal\Console\Bootstrap\Drupal;
use \Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\filter\Entity\FilterFormat;
use Drupal\media\Entity\Media;
use Drupal\menu_link_content\Plugin\Menu\MenuLinkContent;
use Drupal\menu_link_content\Plugin\migrate\source\MenuLink;
use Drupal\menu_link_content\Entity\MenuLinkContent AS MLC;
use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;
use Drupal\os2web_contact\Entity\Contact;

Class Sync
{

    private static $db;

    public static function handler() {

        $now = strftime("%Y-%m-%d %H:%M:%S", time());
        self::$db = \Drupal::database();
        $teachers = Teacher::get();

        // TODO cleanup teachers that is not importet

        $go = false;
        if ( $go && $teachers && is_array($teachers)) {
            foreach ( $teachers as $teacher ) {
                if ($teacher->Active) {

                    $find = self::$db->query("SELECT * FROM os2web_contact__field_import_ref WHERE field_import_ref_value='{$teacher->TeacherId}';");
                    $found = $find->fetchAll();
                    if (count($found) > 0) {
                        $first = current($found);
                        $Contact = Contact::load($first->entity_id);
                    } else {
                        $ContactInfo = array(
                            'name' => $teacher->Name . " " . $teacher->Surname
                        );
                        $Contact = Contact::create($ContactInfo);
                        $Contact->set('field_import_ref', $teacher->TeacherId);
                        $Contact->set('field_os2web_contact_job_title', $teacher->UserType);
                    }

                    if (!empty($teacher->Name)) $Contact->set('field_os2web_contact_firstname', $teacher->Name);
                    if (!empty($teacher->Surname)) $Contact->set('field_os2web_contact_surname', $teacher->Surname);
                    if (!empty($teacher->Email)) $Contact->set('field_os2web_contact_email', $teacher->Email);
                    if (!empty($teacher->Mobile)) $Contact->set('field_os2web_contact_mobile', $teacher->Mobile);
                    if (!empty($teacher->Phone)) $Contact->set('field_os2web_contact_phone', $teacher->Phone);
                    if (!empty($teacher->Address)) $Contact->set('field_adresse', $teacher->Address);
                    if (!empty($teacher->City)) $Contact->set('field_by', $teacher->City);
                    if (!empty($teacher->ZipCode)) $Contact->set('field_postnummer', $teacher->ZipCode);

                    if (!empty($teacher->AvailableClasses) && is_array($teacher->AvailableClasses)) {
                        $Contact->set('field_os2web_contact_job_task', implode(", ", $teacher->AvailableClasses));
                    }

                    if (!empty($teacher->Blob)) {
                        $image = Image::getRequest($teacher->Blob->BlobId, $teacher->Blob->MimeType);
                        if (!empty($image)) {
                            $image_object = \Drupal::service('file.repository')
                                ->writeData($image, 'public://public/' . $teacher->Blob->UniqueId . '.' . $teacher->Blob->Extention, FileSystemInterface::EXISTS_REPLACE);
                            if (is_object($image_object)) {
                                $Contact->set('field_image', array(
                                   'target_id' => $image_object->id(),
                                   'alt' => $teacher->Name . " " . $teacher->Surname,
                                   'title' => $teacher->Name . " " . $teacher->Surname
                                ));
                            }
                        }
                    }

                    if (!empty($teacher->Active)) {
                      $Contact->set('status', 1);
                    } else {
                      $Contact->set('status', 0);
                    }

                    $Contact->save();
                }
            }
        }

        $courses = Course::get();

        $go = true;
        if ($go && !empty($courses) && is_object($courses->tree) && !empty($courses->courses) && is_array($courses->courses)) {
          $tree = array();
          foreach( $courses->tree->Nodes as $node) {
            if ($node->TreeID == 1 && !empty($node->ChildNodes)) {
              $tree = self::children($node->ChildNodes, $courses->courses);
            }
          }

          if (count($tree)) {
            $find = self::$db->query("SELECT * FROM node__field_import_ref WHERE bundle = 'os2web_page' AND field_import_ref_value='-1';");
            $found = $find->fetchAll();
            if (count($found) > 0) {
              $TopPage = current($found)->entity_id;
              foreach ( $tree as $obj ) {
                self::createContent($TopPage, (object) $obj);
              }
            }
          }
        }
    }

    private static function children($ChildNodes, &$courses) {

//      $_tree = array();
//      foreach ($ChildNodes as $idx => $child) {
//        $_child = new \stdClass();
//        $_child->_import_ref = "#_" . $child->TreeID;
//        $_child->_title = ($child->Nodename);
//        $_child->_subtitle = null;
//        $_child->_description = null;
//        $_child->_courses = [];
//        $_child->_children = [];
//
//        if (!empty($child->Courses)) {
//          foreach ($child->Courses as $course) {
//
//            if (isset($courses[$course->CouseId])) {
//              $_course = $courses[$course->CouseId];
//            } else {
//              $_course = new \stdClass();
//            }
//
//            $_course->_import_ref = '#_' . $course->CouseId;
//            $_course->_title = trim($_course->Course ?? $course->Course);
//            $_course->_subtitle = trim($_course->Subject ?? $course->Subject);
//            $_course->_description = trim($_course->Description ?? $course->Description);
//
//            $_child->_courses[] = $_course;
//          }
//        }
//
//        if (!empty($child->ChildNodes)) {
//          $_child->children = self::children($child->ChildNodes, $courses);
//        }
//
//        $_tree[] = $_child;
//      }


      $tree = [];
      foreach ($ChildNodes as $CategoryId => $child) {
        $tree[$CategoryId]['title'] = $child->NodeName;
        $tree[$CategoryId]['treeid'] = $child->TreeID;
        $tree[$CategoryId]['Text'] = $child->NodeDescription;
        $tree[$CategoryId]['children'] = [];
        $tree[$CategoryId]['courses'] = [];
        if (!empty($child->Courses)) {
          foreach ($child->Courses as $course) {
            $tree[$CategoryId]['courses'][$course->CouseId]['title'] = $course->Course;
            foreach ($courses as $courseDef) {
              if ($course->CouseId == $courseDef->CouseId) {
                foreach( $courseDef AS $key => $value ) {
                  $tree[$CategoryId]['courses'][$course->CouseId][$key] = $value;
                }
              }
            }
          }
        }

        if (!empty($child->ChildNodes)) {
          $tree[$CategoryId]['children'] = self::children($child->ChildNodes, $courses);
        }
      }

      return $tree;
    }


    private static function createContent($parentId, $obj) {

      if (!empty($obj->treeid)) {
        $import_ref = $obj->treeid;
      }
      elseif (!empty($obj->CouseId)) {
        $import_ref = $obj->CouseId;
      }

      $find = self::$db->query("SELECT * FROM node__field_import_ref WHERE field_import_ref_value='{$import_ref}';");
      $found = $find->fetchAll();
      if (count($found) > 0) {
          $first = current($found);
          $node = Node::load($first->entity_id);
      } else {
          $node = Node::create(array(
            'title' => $obj->title,
            'type' => 'os2web_page',
          ));
          $node->set('field_import_ref', $import_ref);
      }

      // TODO insert data + images

      if (!empty($obj->Text)) {
        $txt = trim($obj->Text);
        $txt = nl2br($txt);
        $txt = str_replace(array('&nbsp;', '&amp;'), '', $txt);
        $txt = strip_tags($txt);
        $txt = str_replace('<br>', '', $txt);

        $node->set('field_os2web_page_intro', $txt);
      }

      if (!empty($obj->Description)) {
        $txt = trim($obj->Description);
        $txt = nl2br($txt);
        $txt = str_replace(array('&nbsp;', '&amp;'), '', $txt);

        $node->field_os2web_page_description->set(0, array('value' => $txt, 'format' => 'wysiwyg_tekst'));
      }

      $node->save();

      $menu = \Drupal::menuTree()->load('main', new MenuTreeParameters('main'));
      // Find this node in menu
      $found = self::findInMenuLink($node->id(), $menu);
      // if node not in menu
      if (!$found) {
        // Find parrent node in menu
        $found = self::findInMenuLink($parentId, $menu);
        if ($found) {
            $MenuLink = MLC::create(array(
              'title' => $node->getTitle(),
              'link' => 'internal:/node/' . $node->id(),
              'menu_name' => 'main',
              'status' => true,
              'parent' => $found
            ));
            $MenuLink->save();
        }
      }

      if (!empty($obj->courses)) {
        foreach( $obj->courses AS $course ) {
          self::createContent($node->id(), (object) $course);
        }
      }

    }


    private static function findInMenuLink($nodeId, $menu) {
      $found = false;
      foreach( $menu AS $key => $link ) {
        if ($link->link->isEnabled()) {
          $linkNode = $link->link->getUrlObject()->getRouteParameters()['node'];
          if ($nodeId == $linkNode) $found = $link->link->getPluginId();
          if (!$found && $link->hasChildren) {
              $found = self::findInMenuLink($nodeId, $link->subtree);
          }
        }
      }

      return $found;
    }


    private static function createEvent() { }


}