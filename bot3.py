from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import requests
import time
import sys

from selenium.webdriver.chrome.options import Options
cpfFormatado = sys.argv[4]

options = Options()
options.add_argument("--disable-extensions")
options.add_argument('--headless')
options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_experimental_option("prefs", {"download.default_directory": "/home/fairconsultoria/public_html/novoapp/public/storage/certidao/"+cpfFormatado})
driver = webdriver.Chrome(executable_path="/home/fairconsultoria/public_html/novoapp/chromedriver",chrome_options=options)

with driver:
    nomeFormatado = sys.argv[1]
    nascimentoFormatado = sys.argv[2]
    nomeMaeFormatado = sys.argv[3]
    cpfFormatado = sys.argv[4]
    driver.get("https://www10.fazenda.sp.gov.br/CertidaoNegativaDeb/Pages/EmissaoCertidaoNegativa.aspx")
    time.sleep(5)
    driver.find_element(By.XPATH, "//*[@id='MainContent_txtDocumento']").click()
    driver.find_element(By.XPATH, "//*[@id='MainContent_txtDocumento']").send_keys(cpfFormatado)
    time.sleep(5)
    r = requests.get("http://2captcha.com/in.php?key=da8cb7009b4ade6986f284203136fb91&json=1&method=userrecaptcha&googlekey=6LdoPeUUAAAAAIC5yvhe7oc9h4_qf8_Vmq0xd9GU&pageurl=https://www10.fazenda.sp.gov.br/CertidaoNegativaDeb/Pages/EmissaoCertidaoNegativa.aspx")
    crop = r.json()
    print(crop)
    recaptch = ''
    time.sleep(15)
    while (True):
        r = requests.get("http://2captcha.com/res.php?key=da8cb7009b4ade6986f284203136fb91&json=1&action=get&id=" + crop['request'])
        response = r.json()
        if (response['status'] == 1):
            recaptch = response['request']
            print(response['request'])
            break
        if (response['request'] == "ERROR_CAPTCHA_UNSOLVABLE"):
            break
            driver.close()
            driver.switch_to.window(driver.window_handles[-1])
            emitir(cpf)
        time.sleep(5)
        print(response)
    driver.execute_script('document.getElementById("g-recaptcha-response").value = "'+recaptch+'";')
    valor = driver.find_element(By.ID, 'g-recaptcha-response').get_attribute('value')
    driver.find_element(By.ID, 'MainContent_btnPesquisar').click()
    time.sleep(5)
    driver.find_element(By.XPATH, '//*[@id="MainContent_btnImpressao"]').click()
    print("Download Feito")
    time.sleep(5)
    sys.exit()