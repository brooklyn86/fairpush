from operator import index

import time
import json
import base64
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
from selenium.webdriver.common.action_chains import ActionChains
import requests
import urllib.parse

def resert():
    index()

def deleteProcesso(id, false=None):
    print(id)
    getProcessosDelete = requests.get('https://novoapp.fairconsultoria.com.br/app/robo/excluir-processo/%i' % (id))
    if(getProcessosDelete.status_code == 200):
        print('Proecsso Deletado')
    else:
        print('Error: => Erro ao deletar o processo')

def index():
    error = 0
    driver = webdriver.PhantomJS()
    wait = WebDriverWait(driver, 5)
    actions = ActionChains(driver)
    try:
        driver.get("https://esaj.tjsp.jus.br/sajcas/login")
        driver.find_element(By.ID, "usernameForm").click()
        driver.find_element(By.ID, "usernameForm").send_keys("967.933.923-87")
        driver.find_element(By.ID, "passwordForm").click()
        driver.find_element(By.ID, "passwordForm").send_keys("arthur149511")
        driver.find_element(By.ID, "pbEntrar").click()
        driver.get("https://esaj.tjsp.jus.br/cpopg/open.do?gateway=true")
        print("Aguardando Resposta do Servidor com os Processos!")
    except:
        print('Erro: Error de Conexao')
        driver.quit()
        index()
    getProcessos = requests.get('https://novoapp.fairconsultoria.com.br/app/robo/get-processos')
    if(getProcessos.status_code == 200):
        print("Capturados!")
        processosCapturados = getProcessos.json()
        for processos in processosCapturados["data"]:
            novaJanela = 0
            print("Capturando Informacoes do Processo:"+ processos['processo_de_origem'])
            removeEspacos = processos['processo_de_origem'].strip()
            numeroProcesso = removeEspacos.split('.')
            driver.find_element(By.ID, "numeroDigitoAnoUnificado").click()
            driver.find_element(By.ID, "numeroDigitoAnoUnificado").send_keys(numeroProcesso[0]+"."+numeroProcesso[1])
            driver.find_element(By.ID, "foroNumeroUnificado").click()
            foro = numeroProcesso[4].split("/")
            driver.find_element(By.ID, "foroNumeroUnificado").send_keys(foro[0])
            driver.find_element(By.ID, "pbEnviar").click()
            try:
                try:
                    driver.find_element_by_partial_link_text("Precatório - 0"+foro[1]).click()
                    driver.find_element(By.ID,"linkPasta").click()
                    novaJanela = 1
                    driver.switch_to.window(driver.window_handles[1])
                    time.sleep(3)
                    urlAtual = driver.current_url
                    print("Procurando Codigo do processo!")
                    capturarCdProcesso = urlAtual.split("cdProcesso=")
                    cdProcesso = capturarCdProcesso[1].split("&")
                    print("Codigo Processo:"+cdProcesso[0])
                    driver.find_element(By.LINK_TEXT,"Termo de Declaração").click()
                    print("Procurando PDF Correto!")
                    time.sleep(3)
                    urlPdf =  urllib.parse.unquote(driver.find_element(By.ID,"documento").get_property('src'))
                    novoUrlPdf = urlPdf.split("getPDF.do?")
                    codUrl = base64.b64encode(novoUrlPdf[1].encode('utf-8'))
                    print("Pdf encontrado e capturado!")
                    print("Atualizando Processo no Servidor!")
                    driver.get('https://novoapp.fairconsultoria.com.br/app/robo/processo/update/%i/%s/%s' % (processos["id"],cdProcesso[0],codUrl.decode('utf-8')))
                    print(processos["id"])
                    print(cdProcesso[0])
                    print(codUrl.decode('utf-8'))
                    time.sleep(5)
                    print("Processo Atualizado")
                    driver.close()
                    driver.switch_to.window(driver.window_handles[-1])
                except:
                    print("Error: => Precatorio nao encontrado")
                    deleteProcesso(processos["id"])
                    if(novaJanela == 1):
                        driver.close()
                        time.sleep(3)
                        driver.switch_to.window(driver.window_handles[-1])
                time.sleep(2)
            except:
                wait.until(EC.presence_of_element_located((By.ID, 'senhaProcesso')))
                print("Error:  Processo nao e valido")
                deleteProcesso(processos["id"])
                actions.key_down(Keys.ESCAPE)
                actions.key_up(Keys.ESCAPE)
                actions.perform()
            time.sleep(3)
            driver.find_element(By.ID, "numeroDigitoAnoUnificado").clear()
            driver.find_element(By.ID, "foroNumeroUnificado").clear()
        #time.sleep(120)
        #resert()
        exit()
    else:
        print('Error: => Erro ao capturar os processos do servidor')
        print('Tentando novamente')
        error =+ 1
        if(error > 3):
            time.sleep(60)
            resert()

index()
