<?php
namespace Drupal\bc_speed_admin\Controller;

use \Drupal\bc_speed_admin\Controller\Teacher;
use \Drupal\Core\File\FileSystemInterface;
use Drupal\media\Entity\Media;
use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;
use Drupal\os2web_contact\Entity\Contact;

Class Sync
{

    public static function handler() {

        $now = strftime("%Y-%m-%d %H:%M:%S", time());
        $database = \Drupal::database();
        $teachers = Teacher::get();

        // TODO cleanup teachers that is not importet

        if ($teachers && is_array($teachers)) {
            foreach ( $teachers as $teacher ) {
                if ($teacher->Active) {

                    $find = $database->query("SELECT * FROM os2web_contact__field_import_ref WHERE field_import_ref_value='{$teacher->TeacherId}';");
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
                        $Contact->set('field_os2web_contact_job_title', 'Lære');
                    }

                    if (!empty($teacher->Name)) $Contact->set('field_os2web_contact_firstname', $teacher->Name);
                    if (!empty($teacher->Surname)) $Contact->set('field_os2web_contact_surname', $teacher->Surname);
                    if (!empty($teacher->Email)) $Contact->set('field_os2web_contact_email', $teacher->Email);
                    if (!empty($teacher->Mobile)) $Contact->set('field_os2web_contact_mobile', $teacher->Mobile);
                    if (!empty($teacher->Phone)) $Contact->set('field_os2web_contact_phone', $teacher->Phone);
                    if (!empty($teacher->Address)) $Contact->set('field_adresse', $teacher->Address);
                    if (!empty($teacher->City)) $Contact->set('field_by', $teacher->City);
                    if (!empty($teacher->ZipCode)) $Contact->set('field_postnummer', $teacher->ZipCode);

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

                    $Contact->save();
                }
            }
        }
    }

}