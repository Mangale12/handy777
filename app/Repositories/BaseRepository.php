<?php

            namespace App\Repositories;
            use Intervention\Image\Facades\Image;
            use Illuminate\Support\Facades\Log;

            class BaseRepository
            {
                /**
                 * Upload a single image file.
                 *
                 * @param \Illuminate\Http\UploadedFile $file
                 * @param string $folderPath
                 * @param string $prefixPath
                 * @param int|null $width
                 * @param int|null $height
                 * @return string|false
                 */
                public function uploadImage($file, $folderPath, $prefixPath, $width = null, $height = null)
                {
                    try {
                        $this->createFolder($folderPath);
            
                        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
                        if ($width && $height) {
                            $image = Image::make($file->getRealPath());
                            $image->resize($width, $height)->save($folderPath . $fileName);
                        } else {
                            $file->move($folderPath, $fileName);
                        }
            
                        return $prefixPath . $fileName;
                    } catch (\Exception $e) {
                        Log::error('File upload error: ' . $e->getMessage());
                        return false;
                    }
                }
            
                /**
                 * Upload multiple files.
                 *
                 * @param array $files
                 * @param string $folderPath
                 * @param string $prefixPath
                 * @return array
                 */
                public function uploadMultipleFiles($files, $folderPath, $prefixPath)
                {
                    $uploadedPaths = [];
                    try {
                        $this->createFolder($folderPath);
            
                        foreach ($files as $file) {
                            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $file->move($folderPath, $fileName);
                            $uploadedPaths[] = $prefixPath . $fileName;
                        }
                    } catch (\Exception $e) {
                        Log::error('Multiple file upload error: ' . $e->getMessage());
                    }
            
                    return $uploadedPaths;
                }
            
                /**
                 * Delete a file.
                 *
                 * @param string $filePath
                 * @return bool
                 */
                public function deleteFile($filePath)
                {
                    try {
                        if (file_exists(public_path($filePath))) {
                            unlink(public_path($filePath));
                            return true;
                        }
                    } catch (\Exception $e) {
                        Log::error('File deletion error: ' . $e->getMessage());
                    }
            
                    return false;
                }
            
                /**
                 * Create a folder if it does not exist.
                 *
                 * @param string $folderPath
                 * @return void
                 */
                private function createFolder($folderPath)
                {
                    if (!is_dir($folderPath)) {
                        mkdir($folderPath, 0775, true);
                    }
                }
            }
            