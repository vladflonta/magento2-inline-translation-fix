<?php
/**
 * @package     VladFlonta\InlineTranslationFix
 * @author      Vlad Flonta
 * @copyright   Copyright © 2018
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace VladFlonta\InlineTranslationFix\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

class FileManager extends \Magento\Translation\Model\FileManager
{
    /** @var \Magento\Framework\Json\EncoderInterface */
    protected $jsonEncoder;

    /** @var \Magento\Framework\Json\DecoderInterface */
    protected $jsonDecoder;

    /** @var \Magento\Framework\View\Asset\Repository */
    private $assetRepo;

    /** @var \Magento\Framework\App\Filesystem\DirectoryList */
    private $directoryList;

    /** @var \Magento\Framework\Filesystem\Driver\File */
    private $driverFile;

    /**
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Json\DecoderInterface $jsonDecoder
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
     * @param \Magento\Framework\Filesystem\Driver\File $driverFile,
     */
    public function __construct(
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Json\DecoderInterface $jsonDecoder,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $driverFile
    ) {
        $this->assetRepo = $assetRepo;
        $this->directoryList = $directoryList;
        $this->driverFile = $driverFile;
        $this->jsonEncoder = $jsonEncoder;
        $this->jsonDecoder = $jsonDecoder;
        parent::__construct($assetRepo, $directoryList, $driverFile);
    }

    /**
     * @param string $content
     * @return void
     */
    public function updateTranslationFileContent($content) {
        $translationDir = $this->directoryList->getPath(DirectoryList::STATIC_VIEW) .
            \DIRECTORY_SEPARATOR .
            $this->assetRepo->getStaticViewFileContext()->getPath();
        if (!$this->driverFile->isExists($this->getTranslationFileFullPath())) {
            $this->driverFile->createDirectory($translationDir);
        }
        $existingContent = $this->jsonDecoder->decode($this->driverFile->fileGetContents($this->getTranslationFileFullPath()));
        $this->driverFile->filePutContents(
            $this->getTranslationFileFullPath(),
            $this->jsonEncoder->encode(array_merge($existingContent, $this->jsonDecoder->decode($content)))
        );
    }
}
