<?php

require_once '../vendor/autoload.php';

//
//// Services:
//$logWriter = new Writer();
//$encryption = new Encryption();
//$filesManager = new FilesManager($logWriter);
//$dbWrapper = new Wrapper($encryption);
//$mainMenuRepository = new MainMenuRepository($dbWrapper);
//$usersRepository = new UsersRepository($dbWrapper, $encryption);
//$universalFormConfigurationHeaderRepository = new UniversalFormConfigurationHeaderRepository($dbWrapper);
//$universalFormDataRepository = new UniversalFormDataRepository($dbWrapper, $logWriter, $filesManager);
//$authenticator = new Authenticator($usersRepository);
//$responseFromExceptionCreator = new ResponseFromExceptionCreator();
//$dataSaver = new DataSaver($dbWrapper, $encryption, $universalFormDataRepository, $filesManager);
//$dataRemover = new DataRemover($dbWrapper);
//$settingsRepository = new SettingsRepository($dbWrapper);
//$settingsManager = new SettingsManager($dbWrapper, $settingsRepository);
//
//// RPC Commands:
//$rpcCommands[Login::class] = new Login($authenticator);
//$rpcCommands[MainMenuExtractorRpcCommand::class] = new MainMenuExtractorRpcCommand($mainMenuRepository);
//$rpcCommands[DataSourceExtractorRpcCommand::class] = new DataSourceExtractorRpcCommand($universalFormConfigurationHeaderRepository);
//$rpcCommands[ListDataExtractorRpcCommand::class] = new ListDataExtractorRpcCommand($universalFormConfigurationHeaderRepository, $universalFormDataRepository);
//$rpcCommands[DataSaveRpcCommand::class] = new DataSaveRpcCommand($universalFormConfigurationHeaderRepository, $dataSaver);
//$rpcCommands[DeleteRecordsRpcCommand::class] = new DeleteRecordsRpcCommand($universalFormConfigurationHeaderRepository, $dataRemover);
//$rpcCommands[DebugInformationRpcCommand::class] = new DebugInformationRpcCommand($dbWrapper);
//$rpcCommands[UserSettingSaveRpcCommand::class] = new UserSettingSaveRpcCommand($settingsManager, $authenticator);
//$rpcCommands[UserSettingGetRpcCommand::class] = new UserSettingGetRpcCommand($settingsRepository, $authenticator);
//$rpcCommands[AllTablesRpcCommand::class] = new AllTablesRpcCommand($dbWrapper);
//$rpcCommands[AllTableFieldsRpcCommand::class] = new AllTableFieldsRpcCommand($dbWrapper);
//$rpcCommands[FilesUploadRpcCommand::class] = new FilesUploadRpcCommand($universalFormConfigurationHeaderRepository, $dataSaver, $filesManager, $logWriter);
//
//// Prepare final HTML:
//$mainHtmlGenerator = new MainHtmlGenerator($authenticator, $rpcCommands, $responseFromExceptionCreator);
//if (!empty($_POST)) {
//    echo $mainHtmlGenerator->getHtml($_SERVER['REQUEST_METHOD'], $_POST);
//} else {
//    echo $mainHtmlGenerator->getHtml($_SERVER['REQUEST_METHOD'], json_decode(file_get_contents('php://input'), true));
//}
