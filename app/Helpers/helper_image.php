<?php

function helperGetWidthTwoThree($scale = 1)
{
	return 2*$scale;
}
function helperGetHeightTwoThree($scale = 1)
{
	return 3*$scale;
}

function helperGetWidthThreeFour($scale = 1)
{
	return 3*$scale;
}
function helperGetHeightThreeFour($scale = 1)
{
	return 4*$scale;
}

function helperGetPlaceholderImageUrl()
{
	if (file_exists(base_path().'/resources/assets/themes/images/placeholder.png'))
	{
		return url().'/resources/assets/themes/images/placeholder.png';
	}

	return '';
}

function helperGetAvatarImageUrl()
{
	if (file_exists(base_path().'/resources/assets/themes/images/avatar.jpg'))
	{
		return url().'/resources/assets/themes/images/avatar.jpg';
	}

	return '';
}

function helperGetTransparencyImageName()
{
	return 'transparency.png';
}

function helperGetTransparencyImageShortUrl()
{
	if (file_exists(base_path().'/resources/assets/themes/images/effects/'.helperGetTransparencyImageName()))
	{
		return 'resources/assets/themes/images/effects/'.helperGetTransparencyImageName();
	}

	return '';
}

function helperGetTransparencyIconName()
{
	return 'transparency_icon.png';
}

function helperGetTransparencyIconShortUrl()
{
	if (file_exists(base_path().'/resources/assets/themes/images/effects/'.helperGetTransparencyIconName()))
	{
		return 'resources/assets/themes/images/effects/'.helperGetTransparencyIconName();
	}

	return '';
}

function helperGetTransparencyButtonName()
{
	return 'transparency-button.png';
}

function helperGetEffectIconUrl($type)
{
	if (file_exists(base_path().'/resources/assets/themes/images/effects/icon_effect_'.$type.'.png'))
	{
		return url().'/resources/assets/themes/images/effects/icon_effect_'.$type.'.png';
	}

	return '';
}

function helperMediaProductShortPath()
{
	return 'public/products/';
}

function helperMediaProductFullPath()
{
	return base_path().'/'.helperMediaProductShortPath();
}

function helperMediaProductFullUrl()
{
	return url().'/'.helperMediaProductShortPath();
}

function helperMediaTemplateShortPath()
{
	return 'public/templates/';
}

function helperMediaTemplateFullPath()
{
	return base_path().'/'.helperMediaTemplateShortPath();
}

function helperMediaTemplateFullUrl()
{
	return url().'/'.helperMediaTemplateShortPath();
}

function helperRemoveFile($file_path)
{
	if (!is_dir($file_path)) {

		if (file_exists($file_path)) unlink($file_path);
	}
}

function helperMediaPublicShortPath()
{
	return 'public/';
}

function helperMediaPublicFullUrl()
{
	return url().'/'.helperMediaPublicShortPath();
}

function helperMediaPublicFullPath()
{
	return base_path().'/'.helperMediaPublicShortPath();
}

function helperMediaUserShortPath()
{
	return 'users/';
}

function helperMediaPublicUserShortPath()
{
	return 'public/users/';
}

function helperMediaPublicUserFullUrl()
{
	return url().'/'.helperMediaPublicUserShortPath();
}

function helperUserFolderName($id)
{
	return 'user_'.helperPrefixString($id, 6);
}

function helperTeamFolderName($id)
{
	return 'team_'.helperPrefixString($id, 6);
}

function helperProductFolderName($id)
{
	return helperPrefixString($id, 8);
}
