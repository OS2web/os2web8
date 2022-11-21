<?php
namespace Drupal\bc_speed_admin\Controller;

use \Drupal\bc_speed_admin\Controller\Teacher;
use \Drupal\Core\File\FileSystemInterface;
use Drupal\media\Entity\Media;

Class Sync
{

    public static function handler() {

        $now = strftime("%Y-%m-%d %H:%M:%S", time());
        $database = \Drupal::database();
        $teachers = Teacher::get();

        if ($teachers && is_array($teachers)) {
            foreach ( $teachers as $teacher ) {
                if ($teacher->Active) {
                    $imageUri = '';
                    if (!empty($teacher->Blob)) {
                        $image = Image::getRequest($teacher->Blob->BlobId, $teacher->Blob->MimeType);
                        if (!empty($image)) {
                            $image_object = \Drupal::service('file.repository')
                             ->writeData($image, 'public://public/' . $teacher->Blob->UniqueId . '.' . $teacher->Blob->Extention, FileSystemInterface::EXISTS_REPLACE);
                            if (is_object($image_object)) {
                                $imageUri = $image_object->getFileUri();
                            }
                        }
                    }

                    $sql = "
                    INSERT IGNORE INTO
                        speed_admin_teacher
                    SET
                        teacher_id='{$teacher->TeacherId}',
                        teacher_name='{$teacher->Name} {$teacher->Surname}',
                        teacher_email='{$teacher->Email}',
                        teacher_phone='{$teacher->Mobile}',
                        teacher_image='{$imageUri}',
                        teacher_active=1,
                        teacher_updated='{$now}'
                    ON DUPLICATE KEY UPDATE
                        teacher_name='{$teacher->Name} {$teacher->Surname}',
                        teacher_email='{$teacher->Email}',
                        teacher_phone='{$teacher->Mobile}',
                        teacher_image='{$imageUri}',
                        teacher_active=1,
                        teacher_updated='{$now}'
                    ;";
                    $ins = $database->query($sql);
                }
            }
            $database->query("UPDATE speed_admin_teacher SET teacher_active=NULL WHERE teacher_updated<>'{$now}' AND teacher_active=1;");
        }
    }

}