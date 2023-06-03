 Commit message parser:

 - Rozparsuje přijatou commit message na jednotlivé části a ty následně vrátí v entitě CommitMessage

 Podporovaný formát commit message:

 První řádek přijaté zprávy se považuje za subject line, ve kterém se mohou nacházet:
 - Tagy - jsou uzavřené v hranatých závorkách
 - Taks ID - zapisuje se ve formátu "#[číslo]" - v případě více zadaných ID se použije pouze první z nich
 - Titulní popis commitu

 Další případné hodnoty budou ignorovány (např. hodnoty začínající na "@" nebo "#")

 Zbývající vyplněné řádky jsou tělem commit message a podle znaků na začátku řádku se zařadí následovně:
 - "TODO:" - následné úkoly
 - "BC:" - omezení zpětné kompatability
 - "*" - detailní popis commitu

 Tyto znaky jsou nastavovány v konstantách typu array a je tudíž možné v budoucnu rozšířit o další možnosti.
 ----
 Po vytvoření instance CommitMessageParser je možné nastavit, zda bude parser case-sensitive - tedy, zda bude akceptovat např. "bc:" místo "BC:"