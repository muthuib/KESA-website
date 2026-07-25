/**
 * Gallery Upload - With Folder Support (CSRF FIXED)
 * Includes full-page overlay spinner with progress
 */

(function() {
    'use strict';

    console.log('Gallery Upload JS loaded');

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        console.log('Initializing Gallery Upload...');

        // ============================================
        // DOM ELEMENTS
        // ============================================
        
        const uploadZone = document.getElementById('uploadZone');
        const photoInput = document.getElementById('photoInput');
        const folderInput = document.getElementById('folderInput');
        const browsePhotosBtn = document.getElementById('browsePhotosBtn');
        const browseFolderBtn = document.getElementById('browseFolderBtn');
        const previewContainer = document.getElementById('previewContainer');
        const fileCount = document.getElementById('fileCount');
        const fileCountHeader = document.getElementById('fileCountHeader');
        const overallProgress = document.getElementById('overallProgress');
        const overallProgressBar = document.getElementById('overallProgressBar');
        const overallProgressInfo = document.getElementById('overallProgressInfo');
        const uploadButton = document.getElementById('uploadButton');
        const clearQueueBtn = document.getElementById('clearQueueBtn');
        const resetQueueBtn = document.getElementById('resetQueueBtn');
        const uploadForm = document.getElementById('uploadForm');
        const folderInfo = document.getElementById('folderInfo');
        const folderName = document.getElementById('folderName');
        const folderFileCount = document.getElementById('folderFileCount');

        // ============================================
        // GET CSRF TOKEN - MULTIPLE METHODS
        // ============================================
        
        function getCsrfToken() {
            // Method 1: From meta tag
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            if (metaToken) {
                console.log('CSRF token found in meta tag');
                return metaToken.content;
            }
            
            // Method 2: From window object
            if (window.csrfToken) {
                console.log('CSRF token found in window object');
                return window.csrfToken;
            }
            
            // Method 3: From hidden input in form
            const inputToken = document.querySelector('input[name="_token"]');
            if (inputToken) {
                console.log('CSRF token found in hidden input');
                return inputToken.value;
            }
            
            console.error('❌ CSRF token not found!');
            return null;
        }

        // Get the CSRF token
        const CSRF_TOKEN = getCsrfToken();
        console.log('CSRF Token:', CSRF_TOKEN ? '✅ Found' : '❌ Not found');

        // ============================================
        // CHECK ESSENTIAL ELEMENTS
        // ============================================
        
        if (!uploadZone) {
            console.error('❌ uploadZone not found!');
            return;
        }
        
        if (!photoInput) {
            console.error('❌ photoInput not found!');
            return;
        }
        
        if (!folderInput) {
            console.error('❌ folderInput not found!');
            return;
        }

        console.log('✅ All elements found');

        // ============================================
        // CONFIGURATION
        // ============================================
        
        const BATCH_SIZE = 10;
        let selectedFiles = [];
        let isUploading = false;
        let currentUpload = 0;
        let currentFolderName = '';

        // ============================================
        // UPLOAD OVERLAY SPINNER
        // ============================================

        function showUploadingOverlay() {
            // Check if overlay already exists
            let overlay = document.getElementById('uploadOverlay');
            
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'uploadOverlay';
                overlay.innerHTML = `
                    <div class="upload-overlay-content">
                        <div class="upload-spinner-container">
                            <div class="upload-spinner"></div>
                        </div>
                        <div class="upload-spinner-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="upload-overlay-text">
                            <h3>Uploading Photos</h3>
                            <p>Please wait while your photos are being uploaded...</p>
                            <div class="upload-overlay-progress">
                                <div class="upload-overlay-progress-bar" id="uploadOverlayProgressBar" style="width:0%"></div>
                            </div>
                            <span class="upload-overlay-percentage" id="uploadOverlayPercentage">0%</span>
                        </div>
                    </div>
                `;
                document.body.appendChild(overlay);
            }
            
            overlay.classList.add('active');
        }

        function hideUploadingOverlay() {
            const overlay = document.getElementById('uploadOverlay');
            if (overlay) {
                overlay.classList.remove('active');
                // Remove after animation completes
                setTimeout(() => {
                    if (overlay && !overlay.classList.contains('active')) {
                        overlay.remove();
                    }
                }, 500);
            }
        }

        function updateUploadOverlayProgress(percent) {
            const bar = document.getElementById('uploadOverlayProgressBar');
            const text = document.getElementById('uploadOverlayPercentage');
            if (bar) bar.style.width = percent + '%';
            if (text) text.textContent = percent + '%';
        }

        // ============================================
        // EVENT LISTENERS - FIXED FOR FOLDER BROWSING
        // ============================================

        // 1. Browse Photos button
        if (browsePhotosBtn) {
            console.log('Setting up Browse Photos button');
            browsePhotosBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                console.log('Browse Photos clicked - opening file picker');
                photoInput.value = '';
                setTimeout(function() {
                    photoInput.click();
                }, 50);
            });
        }

        // 2. Browse Folder button - FIXED
        if (browseFolderBtn) {
            console.log('Setting up Browse Folder button');
            browseFolderBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                console.log('Browse Folder clicked - opening folder picker');
                folderInput.value = '';
                // Delay to prevent the upload zone click from interfering
                setTimeout(function() {
                    folderInput.click();
                }, 150);
            });
        }

        // 3. Click on upload zone - Only open photo picker
        uploadZone.addEventListener('click', function(e) {
            // Ignore clicks on buttons
            if (e.target.closest('button')) {
                console.log('Click on button inside upload zone - ignored');
                return;
            }
            // Ignore clicks on inputs
            if (e.target.closest('input')) {
                console.log('Click on input inside upload zone - ignored');
                return;
            }
            console.log('Upload zone clicked - opening file picker');
            photoInput.value = '';
            photoInput.click();
        });

        // 4. Photo input change
        photoInput.addEventListener('change', function(e) {
            e.stopPropagation();
            if (this.files && this.files.length > 0) {
                console.log('Files selected:', this.files.length);
                addFiles(this.files, '');
            }
            this.value = '';
        });

        // 5. Folder input change - FIXED
        folderInput.addEventListener('change', function(e) {
            e.stopPropagation();
            console.log('Folder input change event triggered');
            
            if (this.files && this.files.length > 0) {
                console.log('Folder selected with', this.files.length, 'files');
                
                const firstFile = this.files[0];
                let folderPath = firstFile.webkitRelativePath || firstFile.name;
                const folderNameFromPath = folderPath.split('/')[0];
                currentFolderName = folderNameFromPath;
                
                console.log('Folder name:', folderNameFromPath);
                
                if (folderInfo) {
                    folderInfo.classList.add('show');
                    if (folderName) folderName.textContent = `📁 ${folderNameFromPath}`;
                    if (folderFileCount) folderFileCount.textContent = `${this.files.length} files`;
                }
                
                addFiles(this.files, folderNameFromPath);
            }
            this.value = '';
        });

        // 6. Drag and drop
        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                console.log('Files dropped:', e.dataTransfer.files.length);
                
                const files = e.dataTransfer.files;
                let folderNameFromDrop = '';
                
                if (files[0].webkitRelativePath) {
                    folderNameFromDrop = files[0].webkitRelativePath.split('/')[0];
                    console.log('Dropped folder name:', folderNameFromDrop);
                    if (folderInfo) {
                        folderInfo.classList.add('show');
                        if (folderName) folderName.textContent = `📁 ${folderNameFromDrop}`;
                        if (folderFileCount) folderFileCount.textContent = `${files.length} files`;
                    }
                }
                
                addFiles(files, folderNameFromDrop);
            }
        });

        // 7. Upload button
        if (uploadButton) {
            uploadButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Upload button clicked');
                
                if (selectedFiles.length === 0) {
                    alert('Please select at least one image.');
                    return;
                }

                const hasCompleted = selectedFiles.some(f => f.status === 'Completed');
                const hasProcessing = selectedFiles.some(f => f.status === 'Uploading');
                
                if (hasCompleted || hasProcessing) {
                    if (!confirm('Some files have already been processed. Reset and start over?')) {
                        return;
                    }
                    resetQueue();
                }

                startUpload();
            });
        }

        // 8. Clear queue button
        if (clearQueueBtn) {
            clearQueueBtn.addEventListener('click', function() {
                if (isUploading) {
                    alert('Cannot clear queue while upload is in progress.');
                    return;
                }
                if (selectedFiles.length === 0) {
                    alert('Queue is already empty.');
                    return;
                }
                if (confirm('Clear all files from the queue?')) {
                    selectedFiles = [];
                    currentFolderName = '';
                    if (folderInfo) folderInfo.classList.remove('show');
                    updateQueue();
                }
            });
        }

        // 9. Reset queue button
        if (resetQueueBtn) {
            resetQueueBtn.addEventListener('click', function() {
                if (isUploading) {
                    alert('Cannot reset while upload is in progress.');
                    return;
                }
                if (selectedFiles.length === 0) {
                    alert('Queue is already empty.');
                    return;
                }
                if (confirm('Reset all files to waiting status?')) {
                    resetQueue();
                }
            });
        }

        // 10. Remove files (event delegation)
        if (previewContainer) {
            previewContainer.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-btn');
                if (!removeBtn) return;

                if (isUploading) {
                    alert('Cannot remove files while upload is in progress.');
                    return;
                }

                const index = parseInt(removeBtn.dataset.index);
                if (!isNaN(index) && index >= 0 && index < selectedFiles.length) {
                    if (confirm(`Remove "${selectedFiles[index].file.name}" from queue?`)) {
                        selectedFiles.splice(index, 1);
                        if (selectedFiles.length === 0) {
                            currentFolderName = '';
                            if (folderInfo) folderInfo.classList.remove('show');
                        }
                        updateQueue();
                    }
                }
            });
        }

        // 11. Form submission
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
            });
        }

        // ============================================
        // CORE FUNCTIONS
        // ============================================

        function addFiles(files, folderName = '') {
            console.log('Adding files. Count:', files.length, 'Folder:', folderName);
            
            if (isUploading) {
                alert('Cannot add files while upload is in progress.');
                return;
            }

            let addedCount = 0;
            let skippedCount = 0;

            for (const file of files) {
                if (!file.type.startsWith('image/')) {
                    console.log('Skipping non-image:', file.name, file.type);
                    skippedCount++;
                    continue;
                }

                const isDuplicate = selectedFiles.some(f => 
                    f.file.name === file.name && 
                    f.file.size === file.size
                );
                
                if (!isDuplicate) {
                    selectedFiles.push({
                        file: file,
                        status: 'Waiting',
                        progress: 0,
                        folder: folderName || ''
                    });
                    addedCount++;
                } else {
                    console.log('Skipping duplicate:', file.name);
                    skippedCount++;
                }
            }

            console.log('Added:', addedCount, 'Skipped:', skippedCount);

            if (addedCount > 0) {
                updateQueue();
                const folderMsg = folderName ? ` from "${folderName}"` : '';
                showMessage(`Added ${addedCount} image(s)${folderMsg}`);
                if (skippedCount > 0) {
                    showMessage(`Skipped ${skippedCount} non-image or duplicate file(s)`);
                }
            } else {
                showMessage(`No new images to add (${skippedCount} files skipped)`);
            }
        }

        function updateQueue() {
            const count = selectedFiles.length;
            const label = count === 1 ? ' File' : ' Files';
            
            if (fileCount) fileCount.textContent = count + label;
            if (fileCountHeader) fileCountHeader.textContent = count + label;
            
            renderFiles();
            updateStats();
            resetOverallProgress();
        }

        function renderFiles() {
            if (!previewContainer) return;
            
            previewContainer.innerHTML = '';

            if (selectedFiles.length === 0) {
                previewContainer.innerHTML = `
                    <div class="col-12">
                        <div class="empty-queue">
                            <i class="fa fa-images"></i>
                            <p class="mb-0">No images selected. Click "Browse Photos" or "Browse Folder" to start.</p>
                        </div>
                    </div>
                `;
                return;
            }

            selectedFiles.forEach(function(item, index) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-xl-3 col-lg-4 col-md-6 mb-4';
                    col.innerHTML = `
                        <div class="preview-card shadow-sm">
                            ${item.folder ? `<span class="folder-badge"><i class="fa fa-folder"></i> ${item.folder}</span>` : ''}
                            <button
                                class="btn btn-danger btn-sm remove-btn"
                                data-index="${index}"
                                type="button"
                                title="Remove file">
                                <i class="fa fa-times"></i>
                            </button>
                            <img src="${e.target.result}" alt="${item.file.name}">
                            <div class="p-3">
                                <div class="fw-bold text-truncate" title="${item.file.name}">
                                    ${item.file.name}
                                </div>
                                <div class="file-meta">
                                    ${formatSize(item.file.size)}
                                    ${item.folder ? `<span class="ms-2"><i class="fa fa-folder"></i> ${item.folder}</span>` : ''}
                                </div>
                                <div id="status${index}" class="mt-2 status-badge">
                                    <span class="badge bg-secondary">${item.status}</span>
                                </div>
                                <div class="progress mt-2" style="height:20px;">
                                    <div
                                        id="progress${index}"
                                        class="progress-bar progress-bar-striped bg-primary"
                                        style="width:${item.progress}%">
                                        ${item.progress}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                };

                reader.readAsDataURL(item.file);
            });
        }

        function updateStats() {
            if (!overallProgressInfo) return;
            
            const uploaded = selectedFiles.filter(f => f.status === 'Completed').length;
            const failed = selectedFiles.filter(f => f.status === 'Failed').length;
            const processing = selectedFiles.filter(f => f.status === 'Uploading').length;
            
            overallProgressInfo.innerHTML = `
                <i class="fa fa-check-circle text-success"></i> ${uploaded} Uploaded
                <i class="fa fa-times-circle text-danger ms-2"></i> ${failed} Failed
                <i class="fa fa-spinner fa-spin ms-2 text-primary"></i> ${processing} Processing
            `;
        }

        function resetOverallProgress() {
            if (overallProgress) overallProgress.style.display = 'none';
            if (overallProgressBar) {
                overallProgressBar.style.width = '0%';
                overallProgressBar.textContent = '0%';
                overallProgressBar.className = 'progress-bar progress-bar-striped bg-primary';
            }
            updateStats();
        }

        function formatSize(bytes) {
            if (bytes < 1024) return bytes + ' Bytes';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(2) + ' KB';
            return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        }

        function showMessage(message) {
            console.log('📢', message);
        }

        // ============================================
        // UPLOAD FUNCTIONS - WITH OVERLAY SPINNER
        // ============================================

        function startUpload() {
            console.log('Starting upload...');
            
            // Show overlay spinner
            showUploadingOverlay();
            
            // Check CSRF token before starting
            if (!CSRF_TOKEN) {
                alert('CSRF token not found. Please refresh the page and try again.');
                hideUploadingOverlay();
                return;
            }
            
            isUploading = true;
            if (uploadButton) uploadButton.disabled = true;
            currentUpload = 0;
            
            if (overallProgress) overallProgress.style.display = 'block';
            if (overallProgressBar) {
                overallProgressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-primary';
            }
            
            // Reset overlay progress
            updateUploadOverlayProgress(0);
            
            uploadNextBatch();
        }

        function uploadNextBatch() {
            if (currentUpload >= selectedFiles.length) {
                isUploading = false;
                if (uploadButton) uploadButton.disabled = false;
                
                // Update overlay to 100%
                updateUploadOverlayProgress(100);
                
                if (overallProgressBar) {
                    overallProgressBar.style.width = '100%';
                    overallProgressBar.textContent = '100%';
                    overallProgressBar.className = 'progress-bar progress-bar-striped bg-success';
                }
                
                const completed = selectedFiles.filter(f => f.status === 'Completed').length;
                const failed = selectedFiles.filter(f => f.status === 'Failed').length;
                
                updateStats();
                
                // Hide overlay after a short delay
                setTimeout(function() {
                    hideUploadingOverlay();
                    
                    if (failed === 0) {
                        alert(`✅ All ${completed} images uploaded successfully!`);
                    } else {
                        alert(`⚠️ ${completed} uploaded, ${failed} failed`);
                    }
                }, 800);
                
                return;
            }

            uploadBatch(currentUpload);
        }

        function uploadBatch(startIndex) {
            const formData = new FormData();
            
            // Add CSRF token - TRY MULTIPLE METHODS
            console.log('Adding CSRF token to request...');
            
            // Method 1: From meta tag
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            if (metaToken) {
                formData.append('_token', metaToken.content);
                console.log('✅ CSRF token added from meta tag');
            }
            
            // Method 2: From window object
            else if (window.csrfToken) {
                formData.append('_token', window.csrfToken);
                console.log('✅ CSRF token added from window object');
            }
            
            // Method 3: From hidden input
            else {
                const inputToken = document.querySelector('input[name="_token"]');
                if (inputToken) {
                    formData.append('_token', inputToken.value);
                    console.log('✅ CSRF token added from hidden input');
                } else {
                    console.error('❌ No CSRF token found!');
                    alert('CSRF token not found. Please refresh the page.');
                    hideUploadingOverlay();
                    return;
                }
            }

            const end = Math.min(startIndex + BATCH_SIZE, selectedFiles.length);
            console.log(`Uploading batch: ${startIndex} to ${end} (${end - startIndex} files)`);

            for (let i = startIndex; i < end; i++) {
                selectedFiles[i].status = 'Uploading';
                updateStatus(i);
            }
            updateStats();

            for (let i = startIndex; i < end; i++) {
                formData.append('photos[]', selectedFiles[i].file);
            }

            // Log the form data for debugging
            console.log('FormData entries:');
            for (let pair of formData.entries()) {
                if (pair[0] === '_token') {
                    console.log('  _token: [hidden]');
                } else if (pair[0] === 'photos[]') {
                    console.log('  photos[]:', pair[1].name, pair[1].size, 'bytes');
                }
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', window.uploadUrl, true);

            xhr.upload.addEventListener('progress', function(e) {
                if (!e.lengthComputable) return;
                const percent = Math.round((e.loaded / e.total) * 100);
                
                // Update individual file progress
                for (let i = startIndex; i < end; i++) {
                    selectedFiles[i].progress = percent;
                    updateProgress(i, percent);
                }
                
                // Update overlay progress
                updateUploadOverlayProgress(percent);
            });

            xhr.onload = function() {
                console.log('Upload response status:', xhr.status);
                console.log('Upload response:', xhr.responseText);
                
                if (xhr.status === 200) {
                    console.log('✅ Batch uploaded successfully');
                    for (let i = startIndex; i < end; i++) {
                        selectedFiles[i].status = 'Completed';
                        selectedFiles[i].progress = 100;
                        updateStatus(i);
                        updateProgress(i, 100);
                    }
                } else if (xhr.status === 419) {
                    console.error('❌ CSRF token mismatch (419)');
                    alert('Session expired. Please refresh the page and try again.');
                    isUploading = false;
                    if (uploadButton) uploadButton.disabled = false;
                    hideUploadingOverlay();
                    return;
                } else {
                    console.error('❌ Upload failed with status:', xhr.status);
                    for (let i = startIndex; i < end; i++) {
                        selectedFiles[i].status = 'Failed';
                        updateStatus(i);
                    }
                }

                currentUpload += BATCH_SIZE;
                updateOverallProgress();
                updateStats();
                uploadNextBatch();
            };

            xhr.onerror = function() {
                console.error('❌ Network error during upload');
                hideUploadingOverlay();
                for (let i = startIndex; i < end; i++) {
                    selectedFiles[i].status = 'Failed';
                    updateStatus(i);
                }
                currentUpload += BATCH_SIZE;
                updateOverallProgress();
                updateStats();
                uploadNextBatch();
            };

            xhr.send(formData);
        }

        function updateProgress(index, percent) {
            const bar = document.getElementById('progress' + index);
            if (!bar) return;

            bar.style.width = percent + '%';
            bar.textContent = percent + '%';
            
            if (percent === 100) {
                bar.className = 'progress-bar progress-bar-striped bg-success';
            } else if (percent > 50) {
                bar.className = 'progress-bar progress-bar-striped bg-warning';
            } else {
                bar.className = 'progress-bar progress-bar-striped bg-primary';
            }
        }

        function updateStatus(index) {
            const statusEl = document.getElementById('status' + index);
            if (!statusEl) return;

            const status = selectedFiles[index].status;
            const badgeClass = {
                'Waiting': 'bg-secondary',
                'Uploading': 'bg-primary',
                'Completed': 'bg-success',
                'Failed': 'bg-danger'
            }[status] || 'bg-secondary';
            
            statusEl.innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;
        }

        function updateOverallProgress() {
            const completed = selectedFiles.filter(f => f.status === 'Completed').length;
            const failed = selectedFiles.filter(f => f.status === 'Failed').length;
            const processed = completed + failed;
            const total = selectedFiles.length;
            const percent = total > 0 ? Math.round((processed / total) * 100) : 0;

            if (overallProgressBar) {
                overallProgressBar.style.width = percent + '%';
                overallProgressBar.textContent = percent + '%';
                
                if (failed > 0 && completed > 0) {
                    overallProgressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-warning';
                } else if (failed > 0) {
                    overallProgressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-danger';
                } else if (completed === total && total > 0) {
                    overallProgressBar.className = 'progress-bar progress-bar-striped bg-success';
                } else {
                    overallProgressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-primary';
                }
            }
        }

        function resetQueue() {
            selectedFiles.forEach(function(item) {
                item.status = 'Waiting';
                item.progress = 0;
            });

            renderFiles();
            resetOverallProgress();
            currentUpload = 0;
            isUploading = false;
            if (uploadButton) uploadButton.disabled = false;
        }

        // ============================================
        // KEYBOARD SHORTCUTS
        // ============================================

        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.shiftKey && e.key === 'R') {
                e.preventDefault();
                if (!isUploading && selectedFiles.length > 0) {
                    if (confirm('Reset all uploads?')) {
                        resetQueue();
                    }
                }
            }
            
            if (e.key === 'Escape' && !isUploading && selectedFiles.length > 0) {
                if (confirm('Clear all files from the queue?')) {
                    selectedFiles = [];
                    currentFolderName = '';
                    if (folderInfo) folderInfo.classList.remove('show');
                    updateQueue();
                }
            }
        });

        console.log('✅ Gallery Upload with Folder Support initialized successfully!');
        console.log(`📁 Queue: ${selectedFiles.length} files`);
        console.log(`🔗 Upload URL:`, window.uploadUrl);
        console.log(`🔐 CSRF Token:`, CSRF_TOKEN ? '✅ Present' : '❌ Missing');
    }

})();