[![Banner](https://cdn.h33t.moe/images/repo_banners/xenooru.png)](https://github.com/s-vhs/xenooru)

# Xenooru

Super-fast, lightweight flat-file Booru software. Kept very minimalistic and simple but highly customizable and extendable.

## Donate

Saintly and I spent a lot of time developing this software. If you like what we do, please consider donating through either [PayPal](https://paypal.me/WOLFRAMEdev) or [Ko-fi](https://ko-fi.com/saintly). It would mean a lot to us and the donations would be used 100% for server-costs that we need to pay.

## Features

- It's a Booru: Account, Forum, Posting, Commenting, everything included!
- Moderation: All features you need to keep your Booru and its users healthy!
- Super fast: Designed for a fast performance and few dependencies!
- Template-engine: Creating and customize different themes has never been easier!
- Language-system: Create any language-file, translate it and users can use it!
- Flat-file Database: Easy to read, upgrade, edit and uses cache to accelerate the software!

## Installation

- Clone this repository
- Customize `/core/config.php`
- Make `/public/` the root-directory from the webserver
- Create an account
- The basic-installation is done, for further details, read the documentation

## Documentation

[Documentation at the GitHub Wiki](https://github.com/s-vhs/Xenooru/wiki)

## Support

For support, email me at [thencametears@yandex.com](mailto:thencametears@yandex.com) or join the [Team H33T Support-Discord](https://discord.gg/uahG2fKVvg), my username on Discord is `Forsaken Maiden` or whatever, go figure it out yourself.

## Demo

[x3n00ru.h33t.moe](https://x3n00ru.h33t.moe)

## License

[GPL-3.0 license](https://github.com/s-vhs/Xenooru/blob/main/LICENSE)

## Authors

- [@s-vhs](https://www.github.com/s-vhs)
- [@saintly2k](https://www.github.com/saintly2k)

## Technologies used

- [claviska/SimpleImage](https://github.com/claviska/SimpleImage) for Thumbnail-generation for images
- [JamesHeinrich/getID3](https://github.com/JamesHeinrich/getID3) to get Image/Video-dimensions and filesize
- [rakibtg/SleekDB](https://github.com/rakibtg/SleekDB) as Database-software
- [smarty-php/smarty](https://github.com/smarty-php/smarty) as template-engine
- [FFmpeg](https://ffmpeg.org) for Thumbnail-generation for videos