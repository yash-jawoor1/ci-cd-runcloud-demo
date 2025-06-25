pipeline {
  agent any

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Install React dependencies') {
      steps {
        dir('frontend') {
          catchError(buildResult: 'FAILURE', stageResult: 'FAILURE') {
            deleteDir()
            sh 'npm install'
          }
        }
      }
    }

    stage('Build React App') {
      steps {
        dir('frontend') {
          catchError(buildResult: 'FAILURE', stageResult: 'FAILURE') {
            sh 'npm run build'
          }
        }
      }
    }

    stage('Check PHP syntax') {
      steps {
        dir('backend') {
          catchError(buildResult: 'FAILURE', stageResult: 'FAILURE') {
            sh 'php -l index.php'
          }
        }
      }
    }
  }

  post {
    success {
      echo '✅ Build successful!'
    }
    failure {
      echo '❌ Build failed.'
    }
  }
}

