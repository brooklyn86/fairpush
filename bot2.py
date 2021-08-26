from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
import requests
import time
import json
import sys
from selenium.webdriver.chrome.options import Options

cpfFormatado = sys.argv[4]

options = Options()
options.add_argument('--headless')
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_argument("--disable-extensions")
options.add_experimental_option("prefs", {"download.default_directory": "/home/fairconsultoria/public_html/novoapp/public/storage/certidao"+cpfFormatado})
driver = webdriver.Chrome(executable_path="/home/fairconsultoria/public_html/novoapp/chromedriver",chrome_options=options)
with driver:
    nomeFormatado = sys.argv[1]
    nascimentoFormatado = sys.argv[2]
    nomeMaeFormatado = sys.argv[3]
    cpfFormatado = sys.argv[4]
    def emitir(nomeFormatado, nascimentoFormatado,nomeMaeFormatado, cpfFormatado):

        driver.get("https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx")
        time.sleep(5)
        driver.find_element_by_xpath("//*[@id='ctl00_ConteudoPrincipal_ddlTipoCertidao']//option[@value='1']").click()
        time.sleep(5)
        driver.find_element_by_xpath("//*[@id='ctl00_ConteudoPrincipal_ddlTipoDocumento']//option[@value='CPF']").click()
        time.sleep(5)
        driver.find_element(By.XPATH, "//*[@id='ctl00_ConteudoPrincipal_txtCPF']").click()
        driver.find_element(By.XPATH, "//*[@id='ctl00_ConteudoPrincipal_txtCPF']").send_keys(cpfFormatado)

        imagemUrl = driver.find_element(By.ID, "ctl00_ConteudoPrincipal_imgCaptcha").get_attribute('src')

        driver.execute_script("window.open('"+imagemUrl+"', '_blank')")
        driver.switch_to.window(driver.window_handles[1])
        driver.get(imagemUrl)
        driver.save_screenshot('captcha.png')
        files = {'file': open('captcha.png', 'rb')}
        values = {'key': 'da8cb7009b4ade6986f284203136fb91'}
        r = requests.post("http://2captcha.com/in.php", files=files, data=values)
        crop = r.text.split('|')
        recaptch = ''
        while(True):
            r = requests.get("http://2captcha.com/res.php?key=da8cb7009b4ade6986f284203136fb91&json=1&action=get&id="+crop[1])
            response = r.json()
            if(response['status'] == 1):
                recaptch = response['request']
                print(response['request'])
                break
            if (response['request'] == "ERROR_CAPTCHA_UNSOLVABLE"):
                break
                driver.close()
                driver.switch_to.window(driver.window_handles[-1])
                emitir(nomeFormatado, nascimentoFormatado,nomeMaeFormatado, cpfFormatado)
            print(response)
            time.sleep(3)

        driver.close()
        driver.switch_to.window(driver.window_handles[-1])
        driver.find_element(By.ID, "ctl00_ConteudoPrincipal_txtValorCaptcha").send_keys(recaptch)
        driver.find_element(By.ID, "ctl00_ConteudoPrincipal_btnEmitir").click()
        time.sleep(5)
        sys.exit()

           
    emitir(nomeFormatado, nascimentoFormatado,nomeMaeFormatado, cpfFormatado)
