/*CSS*/
import './index.scss';

/* WordPress */
import apiFetch from '@wordpress/api-fetch';

/* Local */
class PatternsAutomotiveSettingsApi {
    constructor() {
        this.endpoint = 'patterns-automotive/v1/settings';
        this.nonce = PatternsAutomotiveLocalize.nonce;
        this.getSettings();
        this.bindEvents();
    }

    async getSettings() {
        try {
            const response = await apiFetch({
                path: this.endpoint,
                headers: {
                    'X-WP-Nonce': this.nonce
                }
            });
            this.settings = response;
            this.updateUI();
        } catch (error) {
            console.error(error);
        }
    }

    bindEvents() {
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('patterns-automotive-gsn-close')) {
                this.modifySettings('hide_get_started_notice', true);
            }
            else if (event.target.classList.contains('patterns-automotive-rn-permanent-close')) {
                this.modifySettings('remove_review_notice_permanently', true);
            }
            else if (event.target.classList.contains('patterns-automotive-rn-temporary-close')) {
                this.modifySettings('remove_review_notice_temporary_date_time', 1);
            }
            else if (event.target.classList.contains('patterns-automotive-install-plugins')) {
                event.target.classList.add("patterns-automotive-processing");
                this.installPlugins();
            }
        });
    }

    async modifySettings(settingKey, settingValue, updateUi = true) {
        const updatedSettings = { ...this.settings, [settingKey]: settingValue };
        try {
            const response = await apiFetch({
                path: this.endpoint,
                method: 'POST',
                data: updatedSettings,
                headers: {
                    'X-WP-Nonce': this.nonce
                }
            });
            this.settings = response;
            if (updateUi) {
                this.updateUI();
            }
        } catch (error) {
            console.error(error);
        }
    }

    isLoadReview() {
        const removeReviewNoticePermanently = this.settings.remove_review_notice_permanently;
        const removeReviewNoticeTemporaryDateTime = this.settings.remove_review_notice_temporary_date_time;
        const themeInstalledDateTime = this.settings.theme_installed_date_time;
        const currentDateTime = this.settings.current_date_time;
        const daysSinceInstallation = (currentDateTime - themeInstalledDateTime) / (60 * 60 * 24);

        if (removeReviewNoticePermanently) {
            return false;
        }

        if (daysSinceInstallation < 15) {
            return false;
        }

        if (!removeReviewNoticeTemporaryDateTime) {
            return true;
        }

        const daysSinceTemporary = (currentDateTime - removeReviewNoticeTemporaryDateTime) / (60 * 60 * 24);

        if (daysSinceTemporary < 15) {
            return false;
        }

        return true;
    }

    updateUI() {
        if (this.settings.hide_get_started_notice) {
            const noticeElement = document.getElementById('patterns-automotive-gsn');
            if (noticeElement) {
                noticeElement.remove();
            }
        }

        if (!this.isLoadReview()) {
            const reviewNoticeElement = document.getElementById('patterns-automotive-review-notice');
            if (reviewNoticeElement) {
                reviewNoticeElement.remove();
            }
        }
    }
    async installPlugins() {
        const plugins = PatternsAutomotiveLocalize.recommended_plugins;
        if (plugins && plugins.length) {
            for (const plugin of plugins) {
                try {
                    await apiFetch({
                        path: 'patterns-automotive/v1/install-plugin',
                        method: 'POST',
                        data: plugin,
                        headers: {
                            'X-WP-Nonce': this.nonce
                        }
                    });
                } catch (error) {
                    console.error(`Failed to install plugin ${plugin.name}:`, error);
                }
            }
        }
        await this.modifySettings('hide_get_started_notice', true, false);
        window.location.replace(PatternsAutomotiveLocalize.theme_info_url);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new PatternsAutomotiveSettingsApi();
});



