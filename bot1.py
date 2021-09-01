# -*- coding: utf-8 -*-

from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
import sys
import time
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
    rgFormatado = sys.argv[5]
    generoFormatado = sys.argv[6]
    driver.get("https://esaj.tjsp.jus.br/sajcas/login")
    driver.find_element(By.ID, "usernameForm").click()
    driver.find_element(By.ID, "usernameForm").send_keys("967.933.923-87")
    driver.find_element(By.ID, "passwordForm").click()
    driver.find_element(By.ID, "passwordForm").send_keys("arthur321")
    driver.find_element(By.ID, "pbEntrar").click()
    driver.get("https://esaj.tjsp.jus.br/sco/abrirCadastro.do")
    time.sleep(5)
    inputElementFruits = driver.find_element_by_xpath("//*[@id='cdModelo']/option[text()='CERT DIST - FALÊNCIAS, CONCORDATAS E RECUPERAÇÕES']").click()
    time.sleep(5)
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").click()
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").send_keys( nomeFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").send_keys(cpfFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").send_keys(rgFormatado)
    if(generoFormatado == 'Masculino'):
        driver.find_element(By.XPATH, "//*[@id='flGeneroM']").click()
    else:
        driver.find_element(By.XPATH, "//*[@id='flGeneroF']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").send_keys("certidoes@fairconsultoria.com.br")
    driver.find_element(By.XPATH, "//*[@id='confirmacaoInformacoes']").click()
    driver.find_element(By.XPATH, "//*[@id='pbEnviar']").click()
    time.sleep(5)
    driver.get("https://esaj.tjsp.jus.br/sco/abrirCadastro.do")
    time.sleep(5)
    inputElementFruits = driver.find_element_by_xpath("//*[@id='cdModelo']/option[text()='CERT DIST - INVENTÁRIOS, ARROLAMENTOS E TESTAMENTOS']").click()
    time.sleep(5)
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").click()
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").send_keys( nomeFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").send_keys(cpfFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").send_keys(rgFormatado)
    if(generoFormatado == 'Masculino'):
        driver.find_element(By.XPATH, "//*[@id='flGeneroM']").click()
    else:
        driver.find_element(By.XPATH, "//*[@id='flGeneroF']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").send_keys("certidoes@fairconsultoria.com.br")
    driver.find_element(By.XPATH, "//*[@id='confirmacaoInformacoes']").click()
    driver.find_element(By.XPATH, "//*[@id='pbEnviar']").click()
    time.sleep(5)
    driver.get("https://esaj.tjsp.jus.br/sco/abrirCadastro.do")
    time.sleep(5)
    inputElementFruits = driver.find_element_by_xpath("//*[@id='cdModelo']//option[@value='6']").click()
    time.sleep(5)
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").click()
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").send_keys( nomeFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").send_keys(cpfFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").send_keys(rgFormatado)
    if(generoFormatado == 'Masculino'):
        driver.find_element(By.XPATH, "//*[@id='flGeneroM']").click()
    else:
        driver.find_element(By.XPATH, "//*[@id='flGeneroF']").click()

    driver.find_element(By.XPATH, "//*[@id='nmMaeCadastro']").click()
    driver.find_element(By.XPATH, "//*[@id='nmMaeCadastro']").send_keys(unicode(nomeMaeFormatado, "utf-8"))
    driver.find_element(By.XPATH, "//*[@id='dataNascimento']").click()
    driver.find_element(By.XPATH, "//*[@id='dataNascimento']").send_keys(nascimentoFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").send_keys("certidoes@fairconsultoria.com.br")
    driver.find_element(By.XPATH, "//*[@id='confirmacaoInformacoes']").click()
    driver.find_element(By.XPATH, "//*[@id='pbEnviar']").click()
    time.sleep(5)
    driver.get("https://esaj.tjsp.jus.br/sco/abrirCadastro.do")
    time.sleep(5)
    inputElementFruits = driver.find_element_by_xpath("//*[@id='cdModelo']//option[@value='52']").click()
    time.sleep(5)
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").click()
    driver.find_element(By.XPATH, "//*[@id='nmCadastroF']").send_keys( nomeFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuCpfFormatado']").send_keys(cpfFormatado)
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.nuRgFormatado']").send_keys(rgFormatado)
    if(generoFormatado == 'Masculino'):
        driver.find_element(By.XPATH, "//*[@id='flGeneroM']").click()
    else:
        driver.find_element(By.XPATH, "//*[@id='flGeneroF']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").click()
    driver.find_element(By.XPATH, "//*[@id='identity.solicitante.deEmail']").send_keys("certidoes@fairconsultoria.com.br")
    driver.find_element(By.XPATH, "//*[@id='confirmacaoInformacoes']").click()
    driver.find_element(By.XPATH, "//*[@id='pbEnviar']").click()
    time.sleep(15)
    driver.get("https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx")

    sys.exit()
